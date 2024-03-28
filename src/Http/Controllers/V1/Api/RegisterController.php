<?php

namespace Callmeaf\Auth\Http\Controllers\V1\Api;

use Callmeaf\Auth\Http\Requests\V1\Api\RegisterRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\RegisterViaEmailRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\RegisterViaMobileRequest;
use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;

class RegisterController extends ApiController
{
    public function __construct(protected AuthService $authService)
    {

    }
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register(data: $request->validated())->getModel(asResource: true,attributes: config('callmeaf-auth.resources.register'));
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
            $user = $this->authService->registerViaMobile(mobile: $request->get('mobile'))->getModel(asResource: true,attributes: config('callmeaf-auth.resources.registerViaMobile'));
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
            $user = $this->authService->registerViaEmail(email: $request->get('email'),password: $request->get('password'))->getModel(asResource: true,attributes: config('callmeaf-auth.resources.registerViaEmail'));
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
