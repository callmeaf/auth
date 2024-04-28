<?php

namespace Callmeaf\Auth\Utilities\V1;

use Callmeaf\Base\Utilities\V1\FormRequestAuthorizer;

class LoginFormRequestAuthorizer extends FormRequestAuthorizer
{
    public function loginViaEmail(): bool
    {
        return true;
    }

    public function loginViaMobile(): bool
    {
        return true;
    }

    public function loginViaOtp(): bool
    {
        return true;
    }
}
