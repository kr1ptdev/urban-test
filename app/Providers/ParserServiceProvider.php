<?php

namespace App\Providers;

use App\Services\NashDomParserService;
use Illuminate\Support\ServiceProvider;

final class ParserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NashDomParserService::class, function ($app): NashDomParserService {
            return new NashDomParserService(
                chromePath: config('nash-dom.chrome_path'),
                baseUrl: config('nash-dom.base_url'),
                endpoint: config('nash-dom.endpoint'),
                defaultParams: config('nash-dom.default_params'),
                timeout: config('nash-dom.timeout', 60),
            );
        });
    }
}