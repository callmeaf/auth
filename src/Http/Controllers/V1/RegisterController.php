<?php

namespace Callmeaf\Auth\Http\Controllers\V1;

use Callmeaf\Auth\Http\Requests\RegisterRequest;
use Callmeaf\Auth\Models\User;
use Callmeaf\Auth\Services\V1\AuthService;

class RegisterController extends BaseController
{
    public function __construct(protected AuthService $authService)
    {

    }
    public function register(RegisterRequest $request)
    {
        return apiResponse([
            'user' => $this->authService->register($request->all())->getModel()
        ]);
    }

    public function registerViaMobile()
    {

    }
}
