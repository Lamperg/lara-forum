<?php

namespace App\Listeners;

use App\Mail\PleaseConfirmYorEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailConfirmationRequest
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->user)->send(new PleaseConfirmYorEmail($event->user));
    }
}
