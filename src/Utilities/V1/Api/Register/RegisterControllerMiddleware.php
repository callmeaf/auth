<?php

namespace Callmeaf\Auth\Utilities\V1\Api\Register;

use Callmeaf\Base\Http\Controllers\BaseController;
use Callmeaf\Base\Utilities\V1\ControllerMiddleware;

class RegisterControllerMiddleware extends ControllerMiddleware
{
    public function __invoke(BaseController $controller): void
    {
        $controller->middleware('guest:sanctum')->only([
            'register',
            'registerViaMobile',
            'registerViaEmail',
        ]);
    }
}
