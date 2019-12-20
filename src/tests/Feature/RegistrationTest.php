<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYorEmail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $registeredEvent = new Registered(create(User::class));
        event($registeredEvent);

        Mail::assertSent(PleaseConfirmYorEmail::class);
    }

    /**
     * @test
     */
    public function user_can_fully_confirmed_their_email_address()
    {
        $this->post('/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        /** @var User $user */
        $user = User::first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $this->get(route('api.register_confirm', [
            'token' => $user->confirmation_token,
        ]));

        $this->assertTrue($user->fresh()->confirmed);
    }
}
