<?php

namespace Callmeaf\Auth\Utilities\V1\Api\Auth;

use Callmeaf\Base\Http\Controllers\BaseController;
use Callmeaf\Base\Utilities\V1\ControllerMiddleware;

class AuthControllerMiddleware extends ControllerMiddleware
{
    public function __invoke(BaseController $controller): void
    {
        $controller->middleware('auth:sanctum')->only([
            'userShow',
            'userUpdate',
            'passwordStore',
            'passwordUpdate',
            'profileImageUpdate',
            'logout',
        ]);
    }
}
