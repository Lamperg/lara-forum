<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->signIn();
    }

    /**
     * @test
     */
    public function notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_current_user()
    {
        /** @var Thread $thread */
        $thread = create(Thread::class)->subscribe();

        $this->assertCount(0, $this->user->notifications);

        $thread->addReply([
            'user_id' => $this->user->id,
            'body' => 'Some reply here'
        ]);

        $this->assertCount(0, $this->user->fresh()->notifications);

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply here'
        ]);

        $this->assertCount(1, $this->user->fresh()->notifications);
    }

    /**
     * @test
     */
    public function user_can_fetch_their_unread_notifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(
            1,
            $this->getJson("profiles/{$this->user->name}/notifications/")->json()
        );
    }

    /**
     * @test
     */
    public function user_can_mark_a_notification_as_read()
    {
        $notification = create(DatabaseNotification::class);

        $this->assertCount(1, $this->user->unreadNotifications);

        $this->delete("profiles/{$this->user->name}/notifications/{$notification->id}");

        $this->assertCount(0, $this->user->fresh()->unreadNotifications);
    }
}
