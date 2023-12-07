<?php

namespace Callmeaf\Auth\Http\Controllers\Api\V1;

use Callmeaf\Auth\Http\Requests\Api\V1\RegisterRequest;
use Callmeaf\Auth\Http\Requests\Api\V1\RegisterViaMobileRequest;
use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Http\Controllers\Api\V1\ApiController;

class RegisterController extends ApiController
{
    public function __construct(protected AuthService $authService)
    {

    }
    public function register(RegisterRequest $request)
    {
        try {
            return apiResponse([
                'user' => $this->authService->register($request->all())->getModel(true)
            ],__('callmeaf::base-v1.successful_created'));
        } catch (\Exception $exception) {
            return apiResponse([]);
        }
    }

    public function registerViaMobile(RegisterViaMobileRequest $request)
    {
        return apiResponse([
            'user' => $this->authService->registerViaMobile($request->get('mobile'))->getModel(true),
        ],__('callmeaf::base-v1.successful_created'));
    }
}
