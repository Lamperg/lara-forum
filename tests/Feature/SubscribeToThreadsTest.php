<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_subscribe_to_threads()
    {
        $this->signIn();

        /** @var Thread $thread */
        $thread = create(Thread::class);

        $this->post("{$thread->path()}/subscriptions");

        $this->assertCount(1, $thread->subscriptions);
    }
}
