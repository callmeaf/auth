<?php

namespace Callmeaf\Auth\Utilities\V1\Api\Auth;

use Callmeaf\Base\Utilities\V1\FormRequestAuthorizer;

class AuthFormRequestAuthorizer extends FormRequestAuthorizer
{
    public function userShow(): bool
    {
        return true;
    }

    public function userUpdate(): bool
    {
        return true;
    }

    public function passwordStore(): bool
    {
        return true;
    }

    public function passwordUpdate(): bool
    {
        return true;
    }

    public function profileImageUpdate(): bool
    {
        return true;
    }

    public function logout(): bool
    {
        return true;
    }
}
