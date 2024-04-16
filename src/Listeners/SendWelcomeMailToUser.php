<?php

namespace Callmeaf\Auth\Listeners;

use Callmeaf\Auth\Events\Registered;
use Callmeaf\Auth\Mails\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMailToUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $email = $event->user->email;
        if($email) {
            Mail::to($email)->send(new WelcomeMail());
        }
    }
}
