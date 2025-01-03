<?php

namespace Callmeaf\Auth\Utilities\V1\Web\Auth;

use Callmeaf\Base\Http\Controllers\BaseController;
use Callmeaf\Base\Utilities\V1\ControllerMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuthWebControllerMiddleware extends ControllerMiddleware
{
    public function __invoke(): array
    {
        return [
            new Middleware(middleware: 'verified',only: [
                'verify_email'
            ])
        ];
    }
}
