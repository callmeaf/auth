<?php

return [
    'model' => \Callmeaf\Auth\Models\PasswordResetToken::class,
    'model_resource' => \Callmeaf\User\Http\Resources\V1\Api\UserResource::class,
    'model_resource_collection' => \Callmeaf\User\Http\Resources\V1\Api\UserCollection::class,
    'service' => \Callmeaf\Auth\Services\V1\PasswordResetTokenService::class,
    'sms_channel' => \Callmeaf\Kavenegar\Services\V1\KavenegarService::class,
    'length' => 5, // code length
    'lifetime' => 60, // seconds
    'default_values' => [

    ],
    'events' => [
        \Callmeaf\Auth\Events\ForgotPasswordCodeSent::class => [
            \Callmeaf\Auth\Listeners\SendForgotPasswordVerificationNotification::class,
        ],
    ],
    'validations' => [
        'forgot_password' => [
            'email_or_mobile' => true,
        ],
        'update_password' => [
            'email_or_mobile' => true,
            'code' => true,
            'password' => true,
        ],
    ],
    'resources' => [
    ],
    'controllers' => [
        'forgot_password' => \Callmeaf\Auth\Http\Controllers\V1\Api\ForgotPasswordController::class,
    ],
    'form_request_authorizers' => [
        'forgot_password' => \Callmeaf\Auth\Utilities\V1\Api\ForgotPassword\ForgotPasswordFormRequestAuthorizer::class,
    ],
    'middlewares' => [
        'forgot_password' => \Callmeaf\Auth\Utilities\V1\Api\ForgotPassword\ForgotPasswordMiddleware::class,
    ],
];
