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
        \Callmeaf\Auth\Events\RegisteredViaMobile::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\RegisteredViaEmail::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\VerifiedEmail::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\LoggedInViaEmail::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\LoggedInViaMobile::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\LoggedInViaOtp::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\LoggedOut::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\PasswordStored::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\PasswordUpdated::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\ProfileImageUpdated::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\UserShowed::class => [
            // listeners
        ],
        \Callmeaf\Auth\Events\UserUpdated::class => [
            // listeners
        ],
    ],
    'validations' => [
        'register' => \Callmeaf\Auth\Utilities\V1\Register\Api\RegisterFormRequestValidator::class,
        'login' => \Callmeaf\Auth\Utilities\V1\Login\Api\LoginFormRequestValidator::class,
        'auth' => \Callmeaf\Auth\Utilities\V1\Auth\Api\AuthFormRequestValidator::class,
        'auth_web' => \Callmeaf\Auth\Utilities\V1\Auth\Web\AuthWebFormRequestValidator::class
    ],
    'resources' => [
        'register' => \Callmeaf\Auth\Utilities\V1\Register\Api\RegisterResources::class,
        'auth' => \Callmeaf\Auth\Utilities\V1\Register\Api\AuthResources::class,
    ],
    'controllers' => [
        'register' => \Callmeaf\Auth\Http\Controllers\V1\Api\RegisterController::class,
        'login' => \Callmeaf\Auth\Http\Controllers\V1\Api\LoginController::class,
        'auth' => \Callmeaf\Auth\Http\Controllers\V1\Api\AuthController::class,
        'auth_web' => \Callmeaf\Auth\Http\Controllers\V1\Web\AuthController::class,
    ],
    'form_request_authorizers' => [
        'auth' => \Callmeaf\Auth\Utilities\V1\Auth\Api\AuthFormRequestAuthorizer::class,
        'auth_web' => \Callmeaf\Auth\Utilities\V1\Auth\Web\AuthWebFormRequestAuthorizer::class,
        'login' => \Callmeaf\Auth\Utilities\V1\Login\Api\LoginFormRequestAuthorizer::class,
        'register' => \Callmeaf\Auth\Utilities\V1\Register\Api\RegisterFormRequestAuthorizer::class,
    ],
    'middlewares' => [
        'register' => \Callmeaf\Auth\Utilities\V1\Register\Api\RegisterControllerMiddleware::class,
        'login' => \Callmeaf\Auth\Utilities\V1\Login\Api\LoginControllerMiddleware::class,
        'auth' => \Callmeaf\Auth\Utilities\V1\Auth\Api\AuthControllerMiddleware::class,
        'auth_web' => \Callmeaf\Auth\Utilities\V1\Auth\Web\AuthWebControllerMiddleware::class,
    ],
];
