<?php

namespace Callmeaf\Auth\Http\Controllers\V1\Api;

use Callmeaf\Auth\Http\Requests\V1\Api\AuthLogoutRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\AuthPasswordStoreRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\AuthPasswordUpdateRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\AuthUserShowRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\AuthUserUpdateRequest;
use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;

class AuthController extends ApiController
{
    public function __construct(protected AuthService $authService)
    {

    }

    public function getUser(AuthUserShowRequest $request)
    {
        try {
            $user = $this->authService->setModel($request->user())->getModel(asResource: true,attributes: config('callmeaf-auth.resources.getUser'));
             return apiResponse([
                 'user' => $user
             ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function updateUser(AuthUserUpdateRequest $request)
    {
        try {
            $user = $this->authService->setModel($request->user())->update(data: $request->validated())->getModel(asResource: true,attributes: config('callmeaf-auth.resources.updateUser'));
             return apiResponse([
                 'user' => $user,
             ],__('callmeaf-base::v1.successful_updated_non_title'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function storePassword(AuthPasswordStoreRequest $request)
    {
        try {
            $this->authService->setModel($request->user())->storePassword(password: $request->get('password'));
             return apiResponse([],__('callmeaf-base::v1.successful_updated_non_title'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function updatePassword(AuthPasswordUpdateRequest $request)
    {
        try {
            $this->authService->setModel($request->user())->updatePassword(currentPassword: $request->get('current_password'),newPassword: $request->get('new_password'));
             return apiResponse([],__('callmeaf-base::v1.successful_updated_non_title'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function logout(AuthLogoutRequest $request)
    {
        try {
            $this->authService->setModel($request->user())->logout();
             return apiResponse([],__('callmeaf-base::v1.successful_logged_out'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }
}
