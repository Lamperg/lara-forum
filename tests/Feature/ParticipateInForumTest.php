<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /**
     * @test
     */
    public function reply_requires_a_body()
    {
        /** @var Thread $thread */
        $thread = create(Thread::class);
        /** @var Reply $reply */
        $reply = make(Reply::class, ['body' => null]);

        $this->actingAs($thread->owner)
            ->post("{$thread->path()}/replies", $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function unauthorized_users_cannot_delete_replies()
    {
        /** @var Reply $reply */
        $reply = create(Reply::class);
        $deleteUrl = route('replies.destroy', $reply);

        $this->delete($deleteUrl)->assertRedirect('login');

        $this->signIn();
        $this->delete($deleteUrl)->assertStatus(403);
    }

    /**
     * @test
     */
    public function authorized_users_can_delete_replies()
    {
        $user = $this->signIn();
        /** @var Reply $reply */
        $reply = create(Reply::class, ['user_id' => $user->id]);

        $this->delete(route('replies.destroy', $reply));

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /**
     * @test
     */
    public function unauthorized_users_cannot_update_replies()
    {
        /** @var Reply $reply */
        $reply = create(Reply::class);
        $updateUrl = route('replies.update', $reply);

        $this->patch($updateUrl)->assertRedirect('login');

        $this->signIn();
        $this->delete($updateUrl)->assertStatus(403);
    }

    /**
     * @test
     */
    public function authorized_users_can_update_replies()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();
        /** @var Reply $reply */
        $reply = create(Reply::class, ['user_id' => $user->id]);

        $attributes = [
            'body' => $this->faker->sentence,
        ];

        $this->patch("/replies/{$reply->id}", $attributes);

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id,
            'body' => $attributes['body'],
        ]);
    }

    /**
     * @test
     */
    public function replies_that_contain_spam_will_not_be_created()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        /** @var Thread $thread */
        $thread = create(Thread::class);
        /** @var Reply $reply */
        $reply = make(Reply::class, [
            'body' => 'Yahoo Customer Support',
        ]);

        $this->expectException(\Exception::class);
        $this
            ->post("{$thread->path()}/replies", $reply->toArray())
            ->assertStatus(422);
    }
}
