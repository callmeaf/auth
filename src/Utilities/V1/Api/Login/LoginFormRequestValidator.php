<?php

namespace Callmeaf\Auth\Utilities\V1\Api\Login;

use Callmeaf\Base\Utilities\V1\FormRequestValidator;

class LoginFormRequestValidator extends FormRequestValidator
{
    public function loginViaEmail(): array
    {
        return [
            'email' => true,
            'password' => true,
            'remember_me' => false,
        ];
    }

    public function loginViaMobile(): array
    {
        return [
            'mobile' => true,
            'password' => true,
            'remember_me' => false,
        ];
    }

    public function loginViaOtp(): array
    {
        return [
            'mobile' => true,
            'code' => true,
            'remember_me' => false,
        ];
    }
}
