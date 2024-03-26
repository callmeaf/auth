<?php

namespace Callmeaf\Auth\Http\Controllers\V1\Api;

use Callmeaf\Auth\Http\Requests\V1\Api\AuthUserRequest;
use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;
use Callmeaf\User\Http\Resources\V1\Api\UserResource;

class AuthController extends ApiController
{
    public function __construct(protected AuthService $authService)
    {

    }

    public function getUser(AuthUserRequest $request)
    {
        try {
             return apiResponse([
                 'user' => new UserResource($request->user(),only: [
                     'id',
                     'status',
                     'status_text',
                     'type',
                     'type_text',
                     'first_name',
                     'last_name',
                     'full_name',
                     'mobile',
                     'email',
                     'national_code',
                 ])
             ],__('callmeaf-base::v1.successful_loaded'));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }
}
