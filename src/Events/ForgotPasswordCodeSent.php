<?php

namespace Callmeaf\Auth\Events;

use Callmeaf\Auth\Models\PasswordResetToken;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordCodeSent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public PasswordResetToken $passwordResetToken)
    {

    }
}
