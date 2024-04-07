<?php

namespace Callmeaf\Auth\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class PasswordResetCodeWasWrongException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-auth::v1.errors.password_reset_code_wrong'), $code ?: Response::HTTP_FORBIDDEN, $previous);
    }
}
