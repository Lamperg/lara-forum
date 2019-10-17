<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Thread
     */
    protected $thread;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /**
     * @test
     */
    public function user_can_view_all_threads()
    {
        $this
            ->get(route('threads.index'))
            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function user_can_read_single_thread()
    {
        $this
            ->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function user_can_filter_threads_according_to_a_channel()
    {
        /** @var Channel $channel */
        $channel = create(Channel::class);
        /** @var Thread $threadNotInChannel */
        $threadNotInChannel = create(Thread::class);
        /** @var Thread $threadInChannel */
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /**
     * @test
     */
    public function user_can_filter_threads_by_any_username()
    {
        $this->signIn(create(User::class, ['name' => 'JohnDoe']));

        /** @var Thread $defaultThread */
        $defaultThread = create(Thread::class);
        /** @var Thread $threadByJohn */
        $threadByJohn = create(Thread::class, ['user_id' => auth()->id()]);

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($defaultThread->title);
    }

    /**
     * @test
     */
    public function user_can_filter_threads_by_popularity()
    {
        $threadWithoutReplies = $this->thread;
        /** @var Thread $threadWithTwoReplies */
        $threadWithTwoReplies = create(Thread::class);
        create(
            Reply::class,
            ['thread_id' => $threadWithTwoReplies->id],
            2
        );
        /** @var Thread $threadWithThreeReplies */
        $threadWithThreeReplies = create(Thread::class);
        create(
            Reply::class,
            ['thread_id' => $threadWithThreeReplies->id],
            3
        );

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

    /**
     * @test
     */
    public function user_can_filter_threads_by_those_that_are_unanswered()
    {
        /** @var Thread $thread */
        $thread = create(Thread::class);
        /** @var Reply $reply */
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response);
    }

    /**
     * @test
     */
    public function user_can_request_all_replies_for_given_thread()
    {
        $twoPageItemsCount = Reply::PAGINATION_ITEMS + 1;

        create(
            Reply::class,
            ['thread_id' => $this->thread->id],
            $twoPageItemsCount
        );

        $response = $this->getJson("{$this->thread->path()}/replies")->json();

        $this->assertCount(Reply::PAGINATION_ITEMS, $response['data']);
        $this->assertEquals($twoPageItemsCount, $response['total']);
    }
}
