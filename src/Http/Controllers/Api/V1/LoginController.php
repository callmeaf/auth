<?php

namespace Callmeaf\Auth\Http\Controllers\Api\V1;

use Callmeaf\Auth\Http\Requests\Api\V1\LoginViaEmailRequest;
use Callmeaf\Auth\Http\Requests\Api\V1\LoginViaMobileRequest;
use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Http\Controllers\Api\V1\ApiController;

class LoginController extends ApiController
{
    public function __construct(protected AuthService $authService)
    {

    }
    public function loginViaEmail(LoginViaEmailRequest $request)
    {
        try {
            $token = $this->authService->loginViaEmail(email: $request->get('email'),password: $request->get('password'),rememberMe: $request->has('remember_me'))->createToken();
             return apiResponse([
                 'token' => $token,
             ],__('callmeaf-base::v1.successful_logged_in'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function loginViaMobile(LoginViaMobileRequest $request)
    {
        try {

        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

}
