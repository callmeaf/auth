<?php

namespace Callmeaf\Auth\Http\Controllers\V1\Api;

use Callmeaf\Auth\Events\LoggedOut;
use Callmeaf\Auth\Events\PasswordStored;
use Callmeaf\Auth\Events\PasswordUpdated;
use Callmeaf\Auth\Events\ProfileImageUpdated;
use Callmeaf\Auth\Events\UserShowed;
use Callmeaf\Auth\Events\UserUpdated;
use Callmeaf\Auth\Http\Requests\V1\Api\AuthLogoutRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\AuthPasswordStoreRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\AuthPasswordUpdateRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\AuthProfileImageUpdateRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\AuthUserShowRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\AuthUserUpdateRequest;
use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;
use Callmeaf\Media\Enums\MediaCollection;
use Callmeaf\Media\Enums\MediaDisk;

class AuthController extends ApiController
{
    protected AuthService $authService;
    public function __construct()
    {
        app(config('callmeaf-auth.middlewares.auth'))($this);
        $this->authService = app(config('callmeaf-auth.service'));
    }

    public function userShow(AuthUserShowRequest $request)
    {
        try {
            $user = $this->authService->setModel($request->user())->getModel(
                asResource: true,
                attributes: config('callmeaf-auth.resources.user_show.attributes'),
                relations: config('callmeaf-auth.resources.user_show.relations'),
                events: [
                    UserShowed::class,
                ],
            );
             return apiResponse([
                 'user' => $user
             ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function userUpdate(AuthUserUpdateRequest $request)
    {
        try {
            $user = $this->authService->setModel($request->user())->update(data: $request->validated(),events: [
                UserUpdated::class,
            ])
                ->getModel(asResource: true,attributes: config('callmeaf-auth.resources.user_update.attributes'),relations: config('callmeaf-auth.resources.user_update.relations'));
             return apiResponse([
                 'user' => $user,
             ],__('callmeaf-base::v1.successful_updated_non_title'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function passwordStore(AuthPasswordStoreRequest $request)
    {
        try {
            $this->authService
                ->setModel($request->user())
                ->storePassword(password: $request->get('password'),events: [
                    PasswordStored::class,
                ]);
             return apiResponse([],__('callmeaf-base::v1.successful_updated_non_title'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function passwordUpdate(AuthPasswordUpdateRequest $request)
    {
        try {
            $this->authService
                ->setModel($request->user())
                ->updatePassword(currentPassword: $request->get('current_password'),newPassword: $request->get('new_password'),events: [
                    PasswordUpdated::class,
                ]);
             return apiResponse([],__('callmeaf-base::v1.successful_updated_non_title'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function profileImageUpdate(AuthProfileImageUpdateRequest $request)
    {
        try {
            $user = $this->authService->setModel($request->user())->createMedia(
                file: $request->file('image'),
                collection: MediaCollection::IMAGE,
                disk: MediaDisk::USERS,
                events: [
                    ProfileImageUpdated::class,
                ],
            )->getModel(asResource: true,attributes: config('callmeaf-auth.resources.profile_image_update.attributes'),relations: config('callmeaf-auth.resources.profile_image_update.relations'));
             return apiResponse([
                 'user' => $user,
             ],__('callmeaf-base::v1.successful_updated_non_title'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }

    public function logout(AuthLogoutRequest $request)
    {
        try {
            $this->authService->setModel($request->user())->logout(events: [
                LoggedOut::class,
            ]);
             return apiResponse([],__('callmeaf-base::v1.successful_logged_out'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }
}
