<?php

namespace App\DTO;

final readonly class NashDomObject
{
    public function __construct(
        public int $domId,
        public string $name,
    ) {
    }

    public static function fromArray(array $data): ?self
    {
        if (!array_key_exists('objId', $data) || !array_key_exists('objCommercNm', $data)) {
            return null;
        }

        $domId = (int) $data['objId'];
        $name = trim((string) $data['objCommercNm']);

        if ($domId <= 0 || $name === '') {
            return null;
        }

        return new self($domId, $name);
    }

    public function toArray(): array
    {
        return [
            'dom_id' => $this->domId,
            'name' => $this->name,
        ];
    }
}
