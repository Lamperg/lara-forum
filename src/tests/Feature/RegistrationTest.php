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
        /** @var User $user */
        $user = make(User::class, [
            'name' => 'John',
            'email' => 'john@example.com',
        ]);

        $user = $this->post('/register', $user->toArray());
        
        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);
    }
}
