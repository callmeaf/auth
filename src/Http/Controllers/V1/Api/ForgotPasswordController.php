<?php

namespace Callmeaf\Auth\Http\Controllers\V1\Api;

use Callmeaf\Auth\Http\Requests\V1\Api\ForgotPasswordRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\UpdatePasswordRequest;
use Callmeaf\Auth\Services\V1\PasswordResetTokenService;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;

class ForgotPasswordController extends ApiController
{
    protected PasswordResetTokenService $passwordResetTokenService;

    public function __construct()
    {
        $this->passwordResetTokenService = app(config('callmeaf-password.service'));
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
             $this->passwordResetTokenService->sendForgotPasswordVerifyCode(emailOrMobile: $request->get('email_or_mobile'));
             return apiResponse([],__('callmeaf-base::v1.successful_sent'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $this->passwordResetTokenService
                ->where(column: 'email_or_mobile',valueOrOperation: $request->get('email_or_mobile'))
                ->first()
                ->updatePassword(code: $request->get('code'),password: $request->get('password'));
             return apiResponse([],__('callmeaf-base::v1.successful_updated_non_title'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }
}