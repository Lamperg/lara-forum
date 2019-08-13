<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use App\Models\Thread;
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
            route('threads.show', $this->thread),
            $this->thread->path()
        );
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
}
