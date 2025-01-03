<?php

namespace Callmeaf\Auth\Http\Controllers\V1\Web;

use Callmeaf\Auth\Events\VerifiedEmail;
use Callmeaf\Auth\Http\Requests\V1\Web\AuthVerifyEmailRequest;
use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Http\Controllers\V1\Web\WebController;

class AuthController extends WebController
{
    protected AuthService $authService;
    public function __construct()
    {
        $this->authService = app(config('callmeaf-auth.service'));
    }

    public static function middleware(): array
    {
        return app(config('callmeaf-auth.middlewares.auth_web'))();
    }

    public function verifyEmail(AuthVerifyEmailRequest $request, $userId)
    {
        try {
            $authService = $this->authService;
            if(array_key_exists('auth',config('callmeaf-auth.middlewares.verify_email'))) {
                $authService->setModel($request->user());
            } else {
                $authService->freshQuery()->where('id',$userId)->first();
            }
            $user = $authService->verifyEmail(events: [
                VerifiedEmail::class,
            ])->getModel(asResource: true,attributes: config('callmeaf-auth.resources.verify_email.attributes'),relations: config('callmeaf-auth.resources.verify_email.relations'));
            return apiResponse([
                'user' => $user,
            ],__('callmeaf-base::v1.successful_verified_email'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }

    }
}
