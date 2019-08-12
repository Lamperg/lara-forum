<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestsMayNotAddReply()
    {
        $this->expectException(AuthenticationException::class);

        $this->post("threads/1/replies", []);
    }

    /**
     * @test
     */
    public function authenticatedUserMayParticipateInForumThreads()
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
