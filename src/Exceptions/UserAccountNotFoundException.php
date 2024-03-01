<?php

namespace Callmeaf\Auth\Exceptions;

class UserAccountNotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-auth::v1.errors.user_account_not_found'), $code, $previous);
    }
}

