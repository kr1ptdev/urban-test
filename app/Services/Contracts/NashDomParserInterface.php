<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface NashDomParserInterface
{
    public function fetchObjects(array $params): Collection;

    public function saveObjects(Collection $objects): int;
}
