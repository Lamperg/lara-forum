<?php

namespace App\Services;

use App\Models\Thread;
use Illuminate\Support\Facades\Redis;

/**
 * Class Visits
 *
 * @package   App\Services
 */
class Visits
{
    /**
     * @var Thread
     */
    protected $thread;

    /**
     * Visits constructor.
     * @param Thread $thread
     */
    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function record()
    {
        Redis::incr($this->cacheKey());
    }

    public function count(): int
    {
        return Redis::get($this->cacheKey()) ?? 0;
    }

    public function reset()
    {
        Redis::del($this->cacheKey());
    }

    protected function cacheKey(): string
    {
        return "threads.{$this->thread->id}.visits";
    }
}
