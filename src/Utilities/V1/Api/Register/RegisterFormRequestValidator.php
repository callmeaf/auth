<?php

namespace Callmeaf\Auth\Utilities\V1\Api\Register;

use Callmeaf\Base\Utilities\V1\FormRequestValidator;

class RegisterFormRequestValidator extends FormRequestValidator
{
    public function register(): array
    {
        return [
            'type' => true,
            'first_name' => true,
            'last_name' => true,
            'mobile' => true,
            'national_code' => true,
            'email' => true,
            'password' => true,
        ];
    }

    public function registerViaMobile(): array
    {
        return [
            'mobile' => true,
            'password' => false,
        ];
    }

    public function registerViaEmail(): array
    {
        return [
            'email' => true,
            'password' => false,
        ];
    }


}
