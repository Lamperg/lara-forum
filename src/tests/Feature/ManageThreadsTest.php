<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Reply;
use Tests\TestCase;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageThreadsTest extends TestCase
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
    public function authenticated_users_must_confirm_email_before_creating_threads()
    {
        $this->publishThread()
            ->assertRedirect('/threads')
            ->assertSessionHas('flash', __('messages.user.confirm_email'));
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
     * @test
     */
    public function unauthorized_user_cannot_delete_thread()
    {
        /** @var Thread $thread */
        $thread = create(Thread::class);
        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertForbidden();
    }

    /**
     * @test
     */
    public function authorized_user_can_delete_own_thread()
    {
        $this->signIn();

        /** @var Thread $thread */
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        /** @var Reply $reply */
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $this->json('delete', $thread->path())->assertStatus(204);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertEquals(0, Activity::count());
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
