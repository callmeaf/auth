<?php

namespace Callmeaf\Auth\Http\Controllers\Api\V1;

use Callmeaf\Auth\Http\Requests\Api\V1\RegisterRequest;
use Callmeaf\Auth\Http\Requests\Api\V1\RegisterViaEmailRequest;
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
            $user = $this->authService->register(data: $request->all())->getModel(true);
            return apiResponse([
                'user' => $user
            ],__('callmeaf-base::v1.successful_created',[
                'title' => $user->fullName,
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([]);
        }
    }

    public function registerViaMobile(RegisterViaMobileRequest $request)
    {
        try {
            $user = $this->authService->registerViaMobile(mobile: $request->get('mobile'))->getModel(true);
             return apiResponse([
                 'user' => $user,
             ],__('callmeaf-base::v1.successful_created',[
                 'title' => $user->mobile,
             ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }

    }

    public function registerViaEmail(RegisterViaEmailRequest $request)
    {
        try {
            $user = $this->authService->registerViaEmail(email: $request->get('email'),password: $request->get('password'))->getModel(true);
            return apiResponse([
                'user' => $user,
            ],__('callmeaf-base::v1.successful_created',[
                'title' => $user->email,
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }
}
