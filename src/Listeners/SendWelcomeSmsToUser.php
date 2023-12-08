<?php

namespace Callmeaf\Auth\Listeners;

use Callmeaf\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

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
        Log::alert($event->user->fullName);
    }
}
