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

    /**
     * @test
     */
    public function user_can_determine_their_avatar_path()
    {
        /** @var User $user */
        $user = create(User::class);
        $this->assertEquals(asset(User::AVATAR_DEFAULT), $user->avatar_path);

        $user->avatar_path = 'avatars/me.jpg';
        $this->assertEquals(asset(User::AVATAR_STORAGE . 'avatars/me.jpg'), $user->avatar_path);
    }
}
