<?php

namespace Callmeaf\Auth\Utilities\V1\ForgotPassword\Api;

use Callmeaf\Base\Utilities\V1\FormRequestAuthorizer;

class ForgotPasswordFormRequestAuthorizer extends FormRequestAuthorizer
{
    public function forgotPassword(): bool
    {
        return true;
    }

    public function updatePassword(): bool
    {
        return true;
    }
}
