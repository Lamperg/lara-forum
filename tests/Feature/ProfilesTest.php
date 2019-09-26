<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_has_profile()
    {
        /** @var User $user */
        $user = create(User::class);

        $this->get(route('profiles.show', $user))
            ->assertSee($user->name);
    }

    /**
     * @test
     */
    public function profiles_display_all_threads_created_by_associated_user()
    {
        $user = $this->signIn();
        /** @var Thread $thread */
        $thread = create(Thread::class, ['user_id' => $user->id]);

        $this->get(route('profiles.show', $user))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
