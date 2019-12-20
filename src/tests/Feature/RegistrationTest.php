<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYorEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();
        $this->registerUser();
        Mail::assertQueued(PleaseConfirmYorEmail::class);
    }

    /**
     * @test
     */
    public function user_can_fully_confirmed_their_email_address()
    {
        Mail::fake();

        $this->registerUser();

        /** @var User $user */
        $user = User::first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $this->get(route('api.register_confirm', [
            'token' => $user->confirmation_token,
        ]));

        $this->assertTrue($user->fresh()->confirmed);
    }

    protected function registerUser(): void
    {
        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);
    }
}
