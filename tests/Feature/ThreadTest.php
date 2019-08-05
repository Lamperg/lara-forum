<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function userCanViewAllThreads()
    {
        /** @var Thread $thread */
        $thread = factory(Thread::class)->create();

        $response = $this->get(route('threads.index'));
        $response->assertSee($thread->title);
    }

    /**
     * @test
     */
    public function userCanReadSingleThread()
    {
        /** @var Thread $thread */
        $thread = factory(Thread::class)->create();

        $response = $this->get(route('threads.show', $thread));
        $response->assertSee($thread->title);
    }
}
