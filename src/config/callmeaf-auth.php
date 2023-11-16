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
    'models' => [
        'auth' => \Callmeaf\Auth\Models\User::class,
    ],
];
