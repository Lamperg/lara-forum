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
    public function userCanViewAllThreads()
    {
        $this
            ->get(route('threads.index'))
            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function userCanReadSingleThread()
    {
        $this
            ->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function userCanReadRepliesThatAreAssociatedWithThread()
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
