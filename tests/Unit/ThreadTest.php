<?php

namespace Tests\Unit;

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
            "/threads/{$this->thread->channel->slug}/{$this->thread->id}",
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
}
