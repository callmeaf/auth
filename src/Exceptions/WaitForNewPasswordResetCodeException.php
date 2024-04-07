<?php

namespace Callmeaf\Auth\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class WaitForNewPasswordResetCodeException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-auth::v1.errors.wait_for_new_password_reset_token'), $code ?: Response::HTTP_TOO_MANY_REQUESTS, $previous);
    }
}
