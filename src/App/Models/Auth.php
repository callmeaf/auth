<?php

namespace Callmeaf\Auth\App\Models;

use App\Models\User;

class Auth extends User
{
    protected $table = 'users';

    public static function configKey(): string
    {
        return 'callmeaf-auth';
    }
}
