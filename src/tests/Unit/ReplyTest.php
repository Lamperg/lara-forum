<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function has_owner()
    {
        /** @var Reply $reply */
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->owner);
    }

    /**
     * @test
     */
    public function it_knows_if_it_was_just_published()
    {
        /** @var Reply $reply */
        $reply = create(Reply::class);
        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();
        $this->assertFalse($reply->wasJustPublished());
    }

    /**
     * @test
     */
    public function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        /** @var Reply $reply */
        $reply = create(Reply::class, [
            'body' => 'Hello @JaneDoe.',
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/JaneDoe">@JaneDoe</a>.',
            $reply->body
        );
    }

    /**
     * @test
     */
    public function it_knows_if_it_is_the_best_reply()
    {
        /** @var Reply $reply */
        $reply = create(Reply::class);
        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);
        $this->assertTrue($reply->fresh()->isBest());
    }
}
