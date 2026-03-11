# Базовый запуск
    php artisan parse:nash-dom

# С параметрами
    php artisan parse:nash-dom --pages=5 --limit=20 --place=77

# Front-end

Inertia.js + Vue 3 (сборка через Vite)

Bootstrap 5 для стилей

Таблица с выводом всех записей

# Back-end

Используется пакет chrome-php/chrome для headless-браузера

Парсер:

    Запускает Chrome в headless-режиме

    Переходит на целевой URL API
    
    Ждёт загрузки контента
    
    Извлекает innerText из <body>
    
    Парсит JSON и маппит поля: objId → dom_id, objCommercNm → name
