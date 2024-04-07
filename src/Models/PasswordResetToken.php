<?php

namespace Callmeaf\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    protected $fillable = [
        'email_or_mobile',
        'code',
        'expired_at',
    ];
}
