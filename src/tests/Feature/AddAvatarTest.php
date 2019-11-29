<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function only_members_can_add_avatars()
    {
        $this->postJson(
            route('api.avatar_store', 1)
        )->assertStatus(401);
    }

    /**
     * @test
     */
    public function a_valid_avatar_must_be_provided()
    {
        $user = $this->signIn();

        $this->postJson(route('api.avatar_store', [
            'user' => $user,
            'avatar' => 'not-at-image',
        ]))->assertStatus(422);
    }

    /**
     * @test
     */
    public function a_user_can_add_avatar_to_his_profile()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpeg');
        $avatarPath = 'avatars/' . $file->hashName();

        $this->postJson("api/users/{$user->id}/avatar", [
            'avatar' => $file,
        ]);

        Storage::disk('public')->assertExists($avatarPath);
        $this->assertEquals($avatarPath, $user->avatar_path);
    }
}
