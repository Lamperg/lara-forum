<?php

namespace App\Services;

use App\Models\Thread;
use Illuminate\Support\Facades\Redis;

/**
 * Class Trending
 * @package App\Services
 */
class Trending
{
    const CACHE_KEY = 'trending_threads';
    const TESTING_CACHE_KEY = 'test_trending_threads';

    /**
     * @return array
     */
    public function get(): array
    {
        return array_map(
            'json_decode',
            Redis::zrevrange($this->cacheKey(), 0, 4)
        );
    }

    /**
     * @param Thread $thread
     */
    public function push(Thread $thread)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'title' => $thread->title,
            'path' => $thread->path()
        ]));
    }

    /**
     * @return string
     */
    public function cacheKey(): string
    {
        return app()->environment('testing') ? self::TESTING_CACHE_KEY : self::CACHE_KEY;
    }

    /**
     *
     */
    public function reset()
    {
        Redis::del($this->cacheKey());
    }
}
