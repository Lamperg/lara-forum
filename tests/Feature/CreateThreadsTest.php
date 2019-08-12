<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestsMayNotCreateThreads()
    {
        $this->expectException(AuthenticationException::class);

        $this->post(route('threads.store'), factory(Thread::class)->raw());
    }

    /**
     * @test
     */
    public function authenticatedUserCanCreateNewForumThreads()
    {
        $this->signIn();

        /** @var Thread $thread */
        $thread = factory(Thread::class)->make();

        $this->post(route('threads.store'), $thread->toArray());

        $this
            ->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}