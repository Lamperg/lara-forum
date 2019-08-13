<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Tests\TestCase;
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
    public function user_can_read_replies_that_are_associated_with_thread()
    {
        /** @var Reply $reply */
        $reply = factory(Reply::class)->create([
            'thread_id' => $this->thread->id,
        ]);

        $this
            ->get($this->thread->path())
            ->assertSee($reply->body);
    }
}
