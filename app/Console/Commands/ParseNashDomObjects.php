<?php

namespace App\Console\Commands;

use App\Services\NashDomParserService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Throwable;

#[AsCommand(name: 'parse:nash-dom', description: 'Парсит ЖК с наш.дом.рф')]
final class ParseNashDomObjects extends Command
{
    protected $signature = 'parse:nash-dom 
                            {--place=77 : ID региона}
                            {--limit=20 : Объектов за запрос}
                            {--pages=1 : Сколько страниц}';

    protected $description = 'Сбор объектов ЖК в таблицу dom_objects';

    public function handle(NashDomParserService $parser): int
    {
        $this->info('Парсим');

        $place = (int) $this->option('place');
        $limit = min((int) $this->option('limit'), 100);
        $pages = (int) $this->option('pages');

        $totalSaved = 0;

        for ($page = 0; $page < $pages; $page++) {
            $offset = $page * $limit;

            try {
                $objects = $parser->fetchObjects([
                    'offset' => $offset,
                    'limit' => $limit,
                    'place' => $place,
                ]);

                if ($objects->isNotEmpty()) {
                    $totalSaved += $parser->saveObjects($objects);
                }
            } catch (Throwable $e) {
                $this->error($e->getMessage());
                continue;
            }
        }

        $this->info(sprintf('Готово, сохранено %d записей', $totalSaved));

        return 0;
    }
}
