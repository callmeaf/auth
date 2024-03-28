<?php

namespace Callmeaf\Auth\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class UserAlreadyHasPasswordException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-auth::v1.errors.user_has_already_password'), $code ?: Response::HTTP_FORBIDDEN, $previous);
    }
}

