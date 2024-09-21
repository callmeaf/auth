<?php

namespace Callmeaf\Auth\Utilities\V1\Api\Login;

use Callmeaf\Base\Http\Controllers\BaseController;
use Callmeaf\Base\Utilities\V1\ControllerMiddleware;

class LoginControllerMiddleware extends ControllerMiddleware
{
    public function __invoke(BaseController $controller): void
    {
        $controller->middleware('guest:sanctum')->only([
            'loginViaEmail',
            'loginViaMobile',
            'loginViaOtp',
        ]);
    }
}
