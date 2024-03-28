<?php

namespace Callmeaf\Auth\Listeners;

use Callmeaf\Auth\Events\Registered;
use Callmeaf\Auth\Services\V1\AuthService;
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
        $user = $event->user;
        $mobile = $user->mobile;
        if($mobile) {
            $authService = app(AuthService::class);
            $authService->smsChannel()->sendViaPattern(
                pattern: config('callmeaf-kavenegar.patterns.welcome.template'),
                mobile: $mobile,
                values: [
                    $user->first_name ?? '',
                ],
            );
        }
    }
}
