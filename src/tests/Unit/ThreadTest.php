<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Thread
     */
    protected $thread;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /**
     * @test
     */
    public function has_path()
    {
        $this->assertEquals(
            "/threads/{$this->thread->channel->slug}/{$this->thread->slug}",
            $this->thread->path());
    }

    /**
     * @test
     */
    public function has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /**
     * @test
     */
    public function has_owner()
    {
        $this->assertInstanceOf(User::class, $this->thread->owner);
    }

    /**
     * @test
     */
    public function can_add_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /**
     * @test
     */
    public function thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn();

        $this->thread
            ->subscribe()
            ->addReply([
                'body' => 'Foobar',
                'user_id' => 1,
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /**
     * @test
     */
    public function belongs_to_a_channel()
    {
        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }

    /**
     * @test
     */
    public function thread_can_be_subscribed_to()
    {
        $this->signIn();
        $this->thread->subscribe();

        $this->assertEquals(
            1,
            $this->thread->subscriptions()->where('user_id', auth()->id())->count()
        );
    }

    /**
     * @test
     */
    public function thread_can_be_unsubscribed_from()
    {
        $this->signIn();
        $this->thread->unsubscribe();

        $this->assertCount(0, $this->thread->subscriptions);
    }

    /**
     * @test
     */
    public function is_knows_if_authenticated_user_is_subscribed_to_it()
    {
        $this->signIn();

        $this->assertFalse($this->thread->isSubscribedTo);
        $this->thread->subscribe();
        $this->assertTrue($this->thread->isSubscribedTo);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function can_check_if_auth_user_has_read_all_replies()
    {
        $user = $this->signIn();

        $this->assertTrue($this->thread->hasUpdatesFor($user));

        $user->read($this->thread);

        $this->assertFalse($this->thread->hasUpdatesFor($user));
    }

    /**
     * @test
     */
    public function it_records_each_visit()
    {
        $this->thread->visits()->reset();
        $this->assertSame(0, $this->thread->visits()->count());

        $this->thread->visits()->record();
        $this->assertEquals(1, $this->thread->visits()->count());

        $this->thread->visits()->record();
        $this->assertEquals(2, $this->thread->visits()->count());
    }

    /**
     * @test
     */
    public function threads_body_is_sanitized_automatically()
    {
        $okayText = "<p>This is okay.</p>";
        $badText = "<script>alert('bad')</script>";

        /** @var Thread $thread */
        $thread = make(Thread::class, [
            'body' => $badText . $okayText
        ]);

        $this->assertEquals($okayText, $thread->body);
    }
}
