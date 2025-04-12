<?php

use Callmeaf\User\App\Enums\UserStatus;
use Callmeaf\User\App\Enums\UserType;

return [
    UserStatus::class => [
        UserStatus::ACTIVE->name => 'فعال',
        UserStatus::INACTIVE->name => 'غیرفعال',
        UserStatus::PENDING->name => 'در انتظار',
    ],
    UserType::class => [
        UserType::NORMAL->name => 'عادی',
        UserType::VIP->name => 'ویژه'
    ],
];
