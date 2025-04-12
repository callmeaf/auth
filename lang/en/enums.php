<?php

use Callmeaf\User\App\Enums\UserStatus;
use Callmeaf\User\App\Enums\UserType;

return [
    UserStatus::class => [
        UserStatus::ACTIVE->name => 'Active',
        UserStatus::INACTIVE->name => 'InActive',
        UserStatus::PENDING->name => 'Pending',
    ],
    UserType::class => [
        UserType::NORMAL->name => 'Normal',
        UserType::VIP->name => 'VIP'
    ],
];
