<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Thread;
use Illuminate\Auth\AuthenticationException;
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
        $this->post(route('threads.store'), [])->assertRedirect('login');
    }

    /**
     * @test
     */
    public function guestsCannotSeeCreateThreadPage()
    {
        $this->get(route('threads.create'))->assertRedirect('login');
    }

    /**
     * @test
     */
    public function authenticatedUserCanCreateNewForumThreads()
    {
        $this->signIn();

        /** @var Thread $thread */
        $thread = make(Thread::class);

        $this->post(route('threads.store'), $thread->toArray());

        $this
            ->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
