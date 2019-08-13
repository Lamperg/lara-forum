<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_add_reply()
    {
        /** @var Thread $thread */
        $thread = create(Thread::class);

        $this->post("{$thread->path()}/replies")->assertRedirect('login');
    }

    /**
     * @test
     */
    public function authenticated_user_may_participate_in_threads()
    {
        $this->signIn();

        /** @var Reply $reply */
        $reply = make(Reply::class);
        /** @var Thread $thread */
        $thread = create(Thread::class);

        $this->post("{$thread->path()}/replies", $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }
}
