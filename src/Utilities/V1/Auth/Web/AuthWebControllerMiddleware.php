<?php

namespace Callmeaf\Auth\Utilities\V1\Auth\Web;

use Callmeaf\Base\Http\Controllers\BaseController;
use Callmeaf\Base\Utilities\V1\ControllerMiddleware;

class AuthWebControllerMiddleware extends ControllerMiddleware
{
    public function __invoke(BaseController $controller): void
    {
        $controller->middleware('verified')->only(['verify_email']);
    }
}
