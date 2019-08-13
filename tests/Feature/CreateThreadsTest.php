<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_create_threads()
    {
        $this->post(route('threads.store'), [])->assertRedirect('login');
    }

    /**
     * @test
     */
    public function guests_cannot_see_create_thread_page()
    {
        $this->get(route('threads.create'))->assertRedirect('login');
    }

    /**
     * @test
     */
    public function authenticated_user_can_create_new_threads()
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
