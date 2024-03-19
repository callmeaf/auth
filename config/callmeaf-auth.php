<?php

return [
    'default_values' => [
        'status' => \Callmeaf\User\Enums\UserStatus::ACTIVE,
        'type' => \Callmeaf\User\Enums\UserType::NORMAL,
    ],
    'model' => \Callmeaf\User\Models\User::class,
    'model_resource' => \Callmeaf\User\Http\Resources\V1\Api\UserResource::class,
    'model_resource_collection' => \Callmeaf\User\Http\Resources\V1\Api\UserCollection::class,
    'events' => [
        \Callmeaf\Auth\Events\Registered::class => [
            \Callmeaf\Auth\Listeners\SendWelcomeSmsToUser::class,
            \Callmeaf\Auth\Listeners\SendWelcomeMailToUser::class
        ],
    ],
    'validations' => [
        'register' => [
            'status' => true,
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
        ],
        'register_via_email' => [
            'email' => true,
            'password' => true,
        ],
        'login_via_email' => [
            'email' => true,
            'password' => true,
            'remember_me' => false,
        ],
        'login_via_mobile' => [
            'mobile' => true,
            'password' => false,
            'remember_me' => false,
        ],
    ],
    'resources' => [
        'register' => [
            'id',
            'first_name',
            'last_name',
            'mobile',
            'email',
            'national_code',
        ],
        'registerViaMobile' => [
            'id',
            'mobile',
        ],
        'registerViaEmail' => [
            'id',
            'email',
        ],
    ],
];
