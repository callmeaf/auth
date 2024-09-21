<?php

namespace Callmeaf\Auth\Utilities\V1\Api\Auth;

use Callmeaf\Base\Utilities\V1\FormRequestValidator;

class AuthFormRequestValidator extends FormRequestValidator
{
    public function userShow(): array
    {
        return [];
    }

    public function userUpdate(): array
    {
        return [
            'first_name' => true,
            'last_name' => true,
            'national_code' => true,
            'email' => false,
        ];
    }

    public function passwordStore(): array
    {
        return [
            'password' => true,
        ];
    }

    public function passwordUpdate(): array
    {
        return [
            'current_password' => true,
            'new_password' => true,
        ];
    }

    public function profileImageUpdate(): array
    {
        return [
            'image' => true,
        ];
    }

    public function logout(): array
    {
        return [];
    }
}
