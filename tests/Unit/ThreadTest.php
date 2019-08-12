<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Thread
     */
    protected $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }

    /**
     * @test
     */
    public function hasPath()
    {
        $this->assertEquals(
            route('threads.show', $this->thread),
            $this->thread->path()
        );
    }

    /**
     * @test
     */
    public function hasReplies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /**
     * @test
     */
    public function hasOwner()
    {
        /** @var Thread $thread */
        $thread = factory(Thread::class)->create();

        $this->assertInstanceOf(User::class, $thread->owner);
    }

    /**
     * @test
     */
    public function canAddReply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
