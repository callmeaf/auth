<?php

return [
    'validations' => [
        'register' => [
            'status' => true,
            'type' => true,
            'first_name' => true,
            'last_name' => true,
            'mobile' => true,
            'national_code' => true,
            'email' => true,
        ],
        'register_via_mobile' => [
            'mobile' => true,
        ],
    ],
    'default_values' => [
        'status' => \Callmeaf\Auth\Enums\UserStatus::ACTIVE,
        'type' => \Callmeaf\Auth\Enums\UserType::NORMAL,
    ],
    'model' => \Callmeaf\User\Models\User::class,
    'model_resource' => \Callmeaf\User\Http\Resources\V1\Api\UserResource::class,
    'model_resource_collection' => \Callmeaf\User\Http\Resources\V1\Api\UserCollection::class,
];
