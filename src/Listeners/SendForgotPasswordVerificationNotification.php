<?php

namespace Callmeaf\Auth\Listeners;

use Callmeaf\Auth\Events\ForgotPasswordCodeSent;
use Callmeaf\Auth\Mail\ForgotPasswordCodeMail;
use Callmeaf\Auth\Services\V1\PasswordResetTokenService;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  ForgotPasswordCodeSent $event
     * @return void
     */
    public function handle(ForgotPasswordCodeSent $event)
    {
        $passwordResetToken = $event->passwordResetToken;
        $emailOrMobile = $passwordResetToken->email_or_mobile;
        if(str($emailOrMobile)->contains('@')) {
            Mail::to($emailOrMobile)->send(new ForgotPasswordCodeMail($passwordResetToken));
        } else {
            $smsChannel = app(config('callmeaf-password.service'))->smsChannel();
            $smsChannel->sendViaPattern(
                pattern: $smsChannel->verifyForgotPasswordCodePattern(),
                mobile: $emailOrMobile,
                values: [
                    $passwordResetToken->code,
                ],
            );
        }
    }
}
