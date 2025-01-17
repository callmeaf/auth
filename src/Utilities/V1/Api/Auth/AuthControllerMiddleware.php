<?php

namespace Callmeaf\Auth\Utilities\V1\Api\Auth;

use Callmeaf\Base\Http\Controllers\BaseController;
use Callmeaf\Base\Utilities\V1\ControllerMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuthControllerMiddleware extends ControllerMiddleware
{
    public function __invoke(): array
    {
        return [
            new Middleware(middleware: 'auth:sanctum',only: [
                'checkUser',
                'userShow',
                'userUpdate',
                'passwordStore',
                'passwordUpdate',
                'profileImageUpdate',
                'logout',
            ])
        ];
    }
}
