<?php

namespace Callmeaf\Auth\Utilities\V1\Api\Register;

use Callmeaf\Base\Http\Controllers\BaseController;
use Callmeaf\Base\Utilities\V1\ControllerMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RegisterControllerMiddleware extends ControllerMiddleware
{
    public function __invoke(): array
    {
        return [
            new Middleware(middleware: 'guest:sanctum',only: [
                'register',
                'registerViaMobile',
                'registerViaEmail',
            ])
        ];
    }
}
