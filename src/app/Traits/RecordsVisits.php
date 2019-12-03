<?php

namespace App\Traits;

use Illuminate\Support\Facades\Redis;

/**
 * Trait RecordsVisits
 * @package App\Traits
 */
trait RecordsVisits
{
    public function recordVisit(): void
    {
        Redis::incr($this->visitsCacheKey());
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?? 0;
    }

    public function resetVisits()
    {
        Redis::del($this->visitsCacheKey());
    }

    protected function visitsCacheKey(): string
    {
        return "threads.{$this->id}.visits";
    }
}
