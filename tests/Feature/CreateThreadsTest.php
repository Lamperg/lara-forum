<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_create_threads()
    {
        $this->get(route('threads.create'))->assertRedirect('login');
        $this->post(route('threads.store'))->assertRedirect('login');
    }

    /**
     * @test
     */
    public function authenticated_user_can_create_new_threads()
    {
        $this->signIn();

        /** @var Thread $thread */
        $thread = make(Thread::class);

        $response = $this->post(route('threads.store'), $thread->toArray());

        $this
            ->get($response->headers->get('location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * @test
     */
    public function thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function thread_requires_a_valid_channel()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $nonExistChannelId = 999;
        $this->publishThread(['channel_id' => $nonExistChannelId])
            ->assertSessionHasErrors('channel_id');
    }

    /**
     * Creates a new thread
     *
     * @param array $overrides
     *
     * @return TestResponse
     */
    public function publishThread(array $overrides = [])
    {
        $this->signIn();
        /** @var Thread $thread */
        $thread = make(Thread::class, $overrides);

        return $this->post(route('threads.store'), $thread->toArray());
    }
}
