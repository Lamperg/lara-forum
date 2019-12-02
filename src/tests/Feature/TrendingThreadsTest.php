<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Redis::del(Thread::REDIS_TRENDING);
    }

    use RefreshDatabase;

    /**
     * @test
     */
    public function thread_score_is_increment_when_it_is_read()
    {
        $this->assertCount(0, Redis::zrevrange(Thread::REDIS_TRENDING, 0, -1));

        /** @var Thread $thread */
        $thread = create(Thread::class);
        $this->call('GET', $thread->path());

        $trending = Redis::zrevrange(Thread::REDIS_TRENDING, 0, -1);

        $this->assertCount(1, $trending);
        $this->assertEquals($thread->title, json_decode($trending[0])->title);
    }
}
