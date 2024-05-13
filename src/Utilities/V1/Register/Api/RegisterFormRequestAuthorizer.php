<?php

namespace Callmeaf\Auth\Utilities\V1\Register\Api;

use Callmeaf\Base\Utilities\V1\FormRequestAuthorizer;

class RegisterFormRequestAuthorizer extends FormRequestAuthorizer
{
    public function register(): bool
    {
        return true;
    }

    public function registerViaMobile(): bool
    {
        return true;
    }

    public function registerViaEmail(): bool
    {
        return true;
    }
}
