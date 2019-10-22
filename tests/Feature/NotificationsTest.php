<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_current_user()
    {
        $user = $this->signIn();
        /** @var Thread $thread */
        $thread = create(Thread::class)->subscribe();

        $this->assertCount(0, $user->notifications);

        $thread->addReply([
            'user_id' => $user->id,
            'body' => 'Some reply here'
        ]);

        $this->assertCount(0, $user->fresh()->notifications);

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply here'
        ]);

        $this->assertCount(1, $user->fresh()->notifications);
    }

    /**
     * @test
     */
    public function user_can_fetch_their_unread_notifications()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();
        /** @var Thread $thread */
        $thread = create(Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply here'
        ]);

        $response = $this->getJson("profiles/{$user->name}/notifications/")->json();

        $this->assertCount(1, $response);
    }

    /**
     * @test
     */
    public function user_can_mark_a_notification_as_read()
    {
        $user = $this->signIn();
        /** @var Thread $thread */
        $thread = create(Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply here'
        ]);

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;
        $this->delete("profiles/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
