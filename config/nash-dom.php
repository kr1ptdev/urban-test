<?php

return [
    'chrome_path' => env('CHROME_PATH', '/snap/chromium/current/usr/lib/chromium-browser/chrome'),
    'base_url' => env('NASH_DOM_BASE_URL', 'https://наш.дом.рф'),
    'endpoint' => '/сервисы/api/kn/object',
    'default_params' => [
        'offset' => 0,
        'limit' => 20,
        'sortField' => 'default',
        'sortType' => 'desc',
        'place' => 77,
        'objStatus' => 0,
    ],
    'timeout' => env('NASH_DOM_TIMEOUT', 60),
];
