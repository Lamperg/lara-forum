<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BestReplyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function thread_create_can_mark_any_reply_as_the_best_reply()
    {
        $user = $this->signIn();
        /** @var Thread $thread */
        $thread = create(Thread::class, ['user_id' => $user->id]);
        /** @var Collection $replies */
        $replies = create(Reply::class, [
            'thread_id' => $thread->id
        ], 2);
        /** @var Reply $bestReply */
        $bestReply = $replies[1];

        $this->postJson(route('replies.best_store', [$bestReply]));

        $this->assertTrue($bestReply->fresh()->isBest());
    }

    /**
     * @test
     */
    public function only_the_thread_creator_may_mark_the_reply_as_best()
    {
        $user = $this->signIn();
        /** @var Thread $thread */
        $thread = create(Thread::class, ['user_id' => $user->id]);
        /** @var Collection $replies */
        $replies = create(Reply::class, ['thread_id' => $thread->id], 2);
        /** @var Reply $bestReply */
        $bestReply = $replies[1];

        $this->signIn(create(User::class));

        $this->postJson(route('replies.best_store', [$bestReply]))->assertStatus(403);

        $this->assertFalse($bestReply->fresh()->isBest());
    }

    /**
     * @test
     */
    public function if_best_reply_is_deleted_than_the_thread_is_updated_to_reflect_that()
    {
        $user = $this->signIn();
        /** @var Reply $reply */
        $reply = create(Reply::class, ['user_id' => $user->id]);

        $reply->thread->markBestReply($reply);
        $this->deleteJson(route('replies.destroy', $reply));

        $this->assertNull($reply->thread->fresh()->best_reply_id);
    }
}
