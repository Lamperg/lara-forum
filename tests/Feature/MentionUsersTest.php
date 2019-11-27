<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function mention_users_in_a_reply_are_notified()
    {
        /** @var User $john */
        $john = create(User::class, [
            'name' => 'JohnDoe',
        ]);
        $this->signIn($john);
        /** @var User $jane */
        $jane = create(User::class, [
            'name' => 'JaneDoe',
        ]);
        /** @var Thread $thread */
        $thread = create(Thread::class);
        /** @var Reply $reply */
        $reply = make(Reply::class, [
            'body' => '@JaneDoe look at this.',
        ]);

        $this->json('post', "{$thread->path()}/replies", $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

    /**
     * @test
     */
    public function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create(User::class, ['name' => 'janeDoe']);
        create(User::class, ['name' => 'johnDoe']);
        create(User::class, ['name' => 'johnDoe2']);

        $this->json('GET', 'api/users', ['name' => 'john'])
            ->assertJsonCount(2);
    }
}
