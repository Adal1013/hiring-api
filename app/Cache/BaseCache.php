<?php

namespace App\Cache;

use Illuminate\Support\Facades\Cache;

abstract class BaseCache
{
    const TTL = 864000;

    protected object $repository;
    protected string $key;
    protected Cache $cache;

    public function __construct(Object $repository, string $key)
    {
        $this->repository = $repository;
        $this->key = $key;
        $this->cache = new Cache();
    }

    protected function forget($key): void
    {
        $this->cache::forget($key);
    }
}
