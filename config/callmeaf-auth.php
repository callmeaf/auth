<?php

return [
    'model' => \Callmeaf\User\Models\User::class,
    'model_resource' => \Callmeaf\User\Http\Resources\V1\Api\UserResource::class,
    'model_resource_collection' => \Callmeaf\User\Http\Resources\V1\Api\UserCollection::class,
    'service' => \Callmeaf\Auth\Services\V1\AuthService::class,
    'sms_channel' => \Callmeaf\Kavenegar\Services\V1\KavenegarService::class,
    'default_values' => [
        'status' => \Callmeaf\User\Enums\UserStatus::ACTIVE,
        'type' => \Callmeaf\User\Enums\UserType::NORMAL,
    ],
    'events' => [
        \Callmeaf\Auth\Events\Registered::class => [
            \Callmeaf\Auth\Listeners\SendWelcomeSmsToUser::class,
            \Callmeaf\Auth\Listeners\SendWelcomeMailToUser::class,
            \Callmeaf\Auth\Listeners\SendEmailVerificationNotification::class,
        ],
        \Callmeaf\Auth\Events\VerifiedEmail::class => [
            //
        ],
    ],
    'validations' => [
        'register' => [
            'type' => true,
            'first_name' => true,
            'last_name' => true,
            'mobile' => true,
            'national_code' => true,
            'email' => true,
            'password' => true,
        ],
        'register_via_mobile' => [
            'mobile' => true,
            'password' => false,
        ],
        'register_via_email' => [
            'email' => true,
            'password' => false,
        ],
        'login_via_email' => [
            'email' => true,
            'password' => true,
            'remember_me' => false,
        ],
        'login_via_mobile' => [
            'mobile' => true,
            'password' => true,
            'remember_me' => false,
        ],
        'login_via_otp' => [
            'mobile' => true,
            'code' => true,
            'remember_me' => false,
        ],
        'user_show' => [

        ],
        'user_update' => [
            'first_name' => true,
            'last_name' => true,
            'national_code' => true,
            'email' => false,
        ],
        'password_store' => [
            'password' => true,
        ],
        'password_update' => [
            'current_password' => true,
            'new_password' => true,
        ],
        'profile_image_update' => [
            'image' => true,
        ],
        'logout' => [
            //
        ],
    ],
    'resources' => [
        'register' => [
            'id',
            'first_name',
            'last_name',
            'mobile',
            'email',
            'email_verified_at',
            'national_code',
        ],
        'registerViaMobile' => [
            'id',
            'mobile',
        ],
        'registerViaEmail' => [
            'id',
            'email',
            'email_verified_at',
        ],
        'getUser' => [
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
            'email_verified_at',
            'national_code',
        ],
        'updateUser' => [
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
            'email_verified_at',
            'national_code',
        ],
        'verify_email' => [
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
            'email_verified_at',
            'national_code',
        ],
        'updateProfileImage' => [
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
            'email_verified_at',
            'national_code',
            'image',
            '!image' => [
                'id',
                'url'
            ],
        ],
    ],
    'controllers' => [
        'register' => \Callmeaf\Auth\Http\Controllers\V1\Api\RegisterController::class,
        'login' => \Callmeaf\Auth\Http\Controllers\V1\Api\LoginController::class,
        'auth' => \Callmeaf\Auth\Http\Controllers\V1\Api\AuthController::class,
        'auth_web' => \Callmeaf\Auth\Http\Controllers\V1\Web\AuthController::class,
    ],
    'middlewares' => [
        'global' => [],
        'register' => [
            'guest:sanctum',
        ],
        'login' => [
            'guest:sanctum',
        ],
        'auth' => [
            'auth:sanctum'
        ],
        'verify_email' => [
            'signed',
        ],
    ],
];
