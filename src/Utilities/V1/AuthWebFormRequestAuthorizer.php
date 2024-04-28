<?php

namespace Callmeaf\Auth\Utilities\V1;

use Callmeaf\Base\Utilities\V1\FormRequestAuthorizer;

class AuthWebFormRequestAuthorizer extends FormRequestAuthorizer
{
    public function verifyEmail(): bool
    {
        if(array_key_exists('auth',config('callmeaf-auth.middlewares.verify_email'))) {
            $authUser = $this->request->user();
            if (! hash_equals((string) $authUser->getKey(), (string) $this->request->route('id'))) {
                return false;
            }

            if (! hash_equals(sha1($authUser->getEmailForVerification()), (string) $this->request->route('hash'))) {
                return false;
            }
        }

        return true;
    }
}
