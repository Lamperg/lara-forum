<?php

namespace Tests\Feature;

use App\Models\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_favorite_anything()
    {
        $this->post('/replies/1/favorites')->assertRedirect('login');
    }

    /**
     * @test
     */
    public function authenticated_user_can_favorite_reply()
    {
        $this->signIn();
        /** @var Reply $reply */
        $reply = create(Reply::class);

        $this->post(route('replies.favorite_store', $reply));

        $this->assertCount(1, $reply->favorites);
    }

    /**
     * @test
     */
    public function authenticated_user_may_favorite_reply_only_once()
    {
        $this->signIn();
        /** @var Reply $reply */
        $reply = create(Reply::class);

        $this->post(route('replies.favorite_store', $reply));
        $this->post(route('replies.favorite_store', $reply));

        $this->assertCount(1, $reply->favorites);
    }
}
