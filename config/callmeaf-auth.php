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
        'register' => \Callmeaf\Auth\Utilities\V1\Api\Register\RegisterFormRequestValidator::class,
        'login' => \Callmeaf\Auth\Utilities\V1\Api\Login\LoginFormRequestValidator::class,
        'auth' => \Callmeaf\Auth\Utilities\V1\Api\Auth\AuthFormRequestValidator::class,
        'auth_web' => \Callmeaf\Auth\Utilities\V1\Web\Auth\AuthWebFormRequestValidator::class
    ],
    'resources' => [
        'register' => \Callmeaf\Auth\Utilities\V1\Api\Register\RegisterResources::class,
        'auth' => \Callmeaf\Auth\Utilities\V1\Api\Register\AuthResources::class,
    ],
    'controllers' => [
        'register' => \Callmeaf\Auth\Http\Controllers\V1\Api\RegisterController::class,
        'login' => \Callmeaf\Auth\Http\Controllers\V1\Api\LoginController::class,
        'auth' => \Callmeaf\Auth\Http\Controllers\V1\Api\AuthController::class,
        'auth_web' => \Callmeaf\Auth\Http\Controllers\V1\Web\AuthController::class,
    ],
    'form_request_authorizers' => [
        'auth' => \Callmeaf\Auth\Utilities\V1\Api\Auth\AuthFormRequestAuthorizer::class,
        'auth_web' => \Callmeaf\Auth\Utilities\V1\Web\Auth\AuthWebFormRequestAuthorizer::class,
        'login' => \Callmeaf\Auth\Utilities\V1\Api\Login\LoginFormRequestAuthorizer::class,
        'register' => \Callmeaf\Auth\Utilities\V1\Api\Register\RegisterFormRequestAuthorizer::class,
    ],
    'middlewares' => [
        'register' => \Callmeaf\Auth\Utilities\V1\Api\Register\RegisterControllerMiddleware::class,
        'login' => \Callmeaf\Auth\Utilities\V1\Api\Login\LoginControllerMiddleware::class,
        'auth' => \Callmeaf\Auth\Utilities\V1\Api\Auth\AuthControllerMiddleware::class,
        'auth_web' => \Callmeaf\Auth\Utilities\V1\Web\Auth\AuthWebControllerMiddleware::class,
    ],
];
