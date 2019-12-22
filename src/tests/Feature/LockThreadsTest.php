<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function non_administrator_may_not_lock_threads()
    {
        $user = $this->signIn();
        /** @var Thread $thread */
        $thread = create(Thread::class, [
            'user_id' => $user->id
        ]);

        $this->post(route('threads.lock', $thread))->assertStatus(403);
        $this->assertFalse(!!$thread->fresh()->locked);
    }

    /**
     * @test
     */
    public function administrators_can_lock_threads()
    {
        /** @var User $adminUser */
        $adminUser = factory(User::class)
            ->states('administrator')
            ->create();

        $this->signIn($adminUser);

        /** @var Thread $thread */
        $thread = create(Thread::class, [
            'user_id' => $adminUser->id
        ]);

        $this->post(route('threads.lock', $thread));
        $this->assertTrue(!!$thread->fresh()->locked);
    }

    /**
     * @test
     */
    public function once_locked_thread_may_not_received_new_replies()
    {
        $user = $this->signIn();
        /** @var Thread $thread */
        $thread = create(Thread::class);

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => $user->id
        ])->assertStatus(422);
    }
}
