<?php

namespace App\Domain\Interfaces\Handlers;

interface CacheHandler
{
    public function setValue(string $key, string $value): void;
    public function getValue(string $key): string;
}
