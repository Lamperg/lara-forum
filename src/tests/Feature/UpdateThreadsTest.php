<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateThreadsTest extends TestCase
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
    public function unauthorized_user_cannot_update_thread()
    {
        /** @var Thread $thread */
        $thread = create(Thread::class, [
            'user_id' => create(User::class)->id,
        ]);

        $this->patch($thread->path(), [])->assertStatus(403);
    }

    /**
     * @test
     */
    public function thread_required_title_and_body_to_be_updated()
    {
        /** @var Thread $thread */
        $thread = create(Thread::class, [
            'user_id' => $this->user->id
        ]);

        $this->patch($thread->path(), [
            'title' => 'Changed',
        ])->assertSessionHasErrors('body');
        $this->patch($thread->path(), [
            'body' => 'Changed',
        ])->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function thread_can_be_updated_by_its_creator()
    {
        /** @var Thread $thread */
        $thread = create(Thread::class, [
            'user_id' => $this->user->id
        ]);

        $this->patch($thread->path(), [
            'title' => 'Changed',
            'body' => 'Changed body',
        ]);

        $this->assertEquals('Changed', $thread->fresh()->title);
        $this->assertEquals('Changed body', $thread->fresh()->body);
    }
}
