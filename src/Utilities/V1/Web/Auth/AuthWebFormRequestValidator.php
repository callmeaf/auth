<?php

namespace Callmeaf\Auth\Utilities\V1\Web\Auth;

use Callmeaf\Base\Utilities\V1\FormRequestValidator;

class AuthWebFormRequestValidator extends FormRequestValidator
{
    public function verifyEmail(): array
    {
        return [];
    }
}
