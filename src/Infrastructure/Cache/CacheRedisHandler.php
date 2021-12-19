<?php

namespace App\Infrastructure\Cache;

use App\Domain\Interfaces\Handlers\CacheHandler;

class CacheRedisHandler implements CacheHandler
{
    /** Redis $redis */
    private $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect($_ENV['CACHEHOST'], $_ENV['CACHEPORT']);
    }

    public function setValue(string $key, string $value): void
    {
        $this->redis->set($key, $value);
    }

    public function getValue(string $key): string
    {
        return $this->redis->get($key);
    }
}
