<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function user_can_fetch_the_most_recent_reply()
    {
        /** @var User $user */
        $user = create(User::class);
        /** @var Reply $reply */
        $reply = create(Reply::class, ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }
}
