<?php

namespace Callmeaf\Auth\Services\V1\Contracts;

use Callmeaf\Auth\Services\V1\PasswordResetTokenService;
use Callmeaf\Base\Services\V1\Contracts\BaseServiceInterface;
use Callmeaf\Sms\Services\V1\SmsService;

interface PasswordResetTokenServiceInterface extends BaseServiceInterface
{
    public function smsChannel(): SmsService;
    public function sendForgotPasswordVerifyCode(string $emailOrMobile): PasswordResetTokenService;
    public function newCode(): string;
    public function updatePassword(string $code,string $password): PasswordResetTokenService;
}
