<?php

namespace App\Services;

use App\DTO\NashDomObject;
use App\Models\DomObject;
use HeadlessChromium\BrowserFactory;
use Illuminate\Support\Collection;
use RuntimeException;

final class NashDomParserService
{
    private BrowserFactory $browserFactory;

    public function __construct(
        private readonly string $chromePath,
        private readonly string $baseUrl,
        private readonly string $endpoint,
        private readonly array $defaultParams,
        private readonly int $timeout = 60,
    ) {
        $this->browserFactory = new BrowserFactory($chromePath);
    }

    public function fetchObjects(array $params = []): Collection
    {
        $url = $this->buildUrl($params);
        $html = $this->fetchPageContent($url);
        $data = $this->parseJson($html);
        $items = $this->extractItems($data);

        return $this->mapToDtoCollection($items);
    }

    public function saveObjects(Collection $objects): int
    {
        if ($objects->isEmpty()) {
            return 0;
        }

        return DomObject::upsert(
            $objects->map(fn(NashDomObject $dto): array => $dto->toArray())->toArray(),
            ['dom_id'],
            ['name']
        );
    }

    private function buildUrl(array $params): string
    {
        $query = http_build_query(array_merge($this->defaultParams, $params));

        return sprintf(
            '%s%s?%s',
            rtrim($this->baseUrl, '/'),
            $this->endpoint,
            $query
        );
    }

    private function fetchPageContent(string $url): string
    {
        $browser = $this->browserFactory->createBrowser([
            'headless' => true,
            'startupTimeout' => $this->timeout,
            'customFlags' => [
                '--no-first-run',
                '--no-default-browser-check',
                '--disable-blink-features=AutomationControlled',
                '--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--disable-gpu',
            ],
        ]);

        try {
            $page = $browser->createPage();
            $page->navigate($url)->waitForNavigation();
            $this->waitForBody($page);
            sleep(3);

            return $page->evaluate('document.body.innerText')->getReturnValue();
        } finally {
            $browser->close();
        }
    }

    private function waitForBody($page): void
    {
        for ($i = 0; $i < 100; $i++) {
            if ($page->evaluate('!!document.body')->getReturnValue()) {
                return;
            }
            usleep(100_000);
        }
    }

    private function parseJson(string $html): array
    {
        $decoded = json_decode($html, true, 512, JSON_THROW_ON_ERROR);

        if (!array_key_exists('data', $decoded)) {
            return [];
        }

        return $decoded;
    }

    private function extractItems(array $data): array
    {
        if (array_key_exists('list', $data['data']) && is_array($data['data']['list'])) {
            return $data['data']['list'];
        }

        if (is_array($data['data'])) {
            return $data['data'];
        }

        return [];
    }

    private function mapToDtoCollection(array $items): Collection
    {
        return collect($items)
            ->map(fn(array $item): ?NashDomObject => NashDomObject::fromArray($item))
            ->filter();
    }
}
