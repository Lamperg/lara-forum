<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Services\Trending;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Trending
     */
    protected $trending;

    protected function setUp(): void
    {
        parent::setUp();

        $this->trending = app(Trending::class);
        $this->trending->reset();
    }

    /**
     * @test
     */
    public function thread_score_is_increment_when_it_is_read()
    {
        $this->withoutExceptionHandling();

        $this->assertCount(0, $this->trending->get());

        /** @var Thread $thread */
        $thread = create(Thread::class);
        $this->call('GET', $thread->path());

        $trending = $this->trending->get();

        $this->assertCount(1, $trending);
        $this->assertEquals($thread->title, $trending[0]->title);
    }
}
