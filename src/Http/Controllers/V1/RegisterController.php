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
        ],__('callmeaf::base-v1.unknown_error'));
    }

    public function registerViaMobile()
    {

    }
}
