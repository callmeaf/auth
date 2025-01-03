<?php

namespace Callmeaf\Auth\Http\Controllers\V1\Api;

use Callmeaf\Auth\Events\LoggedInViaEmail;
use Callmeaf\Auth\Events\LoggedInViaMobile;
use Callmeaf\Auth\Events\LoggedInViaOtp;
use Callmeaf\Auth\Http\Requests\V1\Api\LoginViaEmailRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\LoginViaMobileRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\LoginViaOtpRequest;
use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;

class LoginController extends ApiController
{
    protected AuthService $authService;
    public function __construct()
    {
        $this->authService = app(config('callmeaf-auth.service'));
    }

    public static function middleware(): array
    {
        return app(config('callmeaf-auth.middlewares.login'))();
    }

    public function loginViaEmail(LoginViaEmailRequest $request)
    {
        try {
            logger('passed');
            $token = $this->authService
                ->loginViaEmail(email: $request->get('email'),password: $request->get('password'),rememberMe: $request->has('remember_me'),events: [
                    LoggedInViaEmail::class
                ])
                ->createToken();
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
            $token = $this->authService
                ->loginViaMobile(mobile: $request->get('mobile'),password: $request->get('password'),rememberMe: $request->has('remember_me'),events: [
                    LoggedInViaMobile::class
                ])
                ->createToken();
            return apiResponse([
                'token' => $token,
            ],__('callmeaf-base::v1.successful_logged_in'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function loginViaOtp(LoginViaOtpRequest $request)
    {
        try {
            $token = $this->authService
                ->loginViaOtp(mobile: $request->get('mobile'),code: $request->get('code'),rememberMe: $request->has('remember_me'),events: [
                    LoggedInViaOtp::class,
                ])
                ->createToken();
             return apiResponse([
                 'token' => $token,
             ],__('callmeaf-base::v1.successful_logged_in'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

}
