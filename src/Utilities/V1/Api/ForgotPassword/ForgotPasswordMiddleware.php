<?php

namespace Callmeaf\Auth\Utilities\V1\Api\ForgotPassword;

use Callmeaf\Base\Http\Controllers\BaseController;
use Callmeaf\Base\Utilities\V1\ControllerMiddleware;

class ForgotPasswordMiddleware extends ControllerMiddleware
{
    public function __invoke(BaseController $controller): void
    {
        $controller->middleware([
            'guest:sanctum',
        ])->only([
            'forgotPassword',
            'updatePassword',
        ]);
        $controller->middleware([
            'throttle:1,1',
        ])->only([
            'forgotPassword',
        ]);
    }
}
