<?php

namespace Callmeaf\Auth\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class CurrentPasswordIncorrectException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?: __('callmeaf-auth::v1.errors.current_password_incorrect'), $code ?: Response::HTTP_FORBIDDEN, $previous);
    }
}

