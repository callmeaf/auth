<?php

namespace Callmeaf\Auth\Listeners;

use Callmeaf\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeSmsToUser
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
        $mobile = $event->user->mobile;
        if($mobile) {
            // TODO: mobile configuration for sending sms
        }
    }
}
