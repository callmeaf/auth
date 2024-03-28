<?php

namespace Callmeaf\Auth\Services\V1\Contracts;

use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Services\V1\Contracts\BaseServiceInterface;
use Callmeaf\Sms\Services\V1\SmsService;
use Illuminate\Http\Request;

interface AuthServiceInterface extends BaseServiceInterface
{
    public function register(array $data): AuthService;
    public function registerViaMobile(string $mobile,?string $password = null): AuthService;
    public function registerViaEmail(string $email,?string $password = null): AuthService;
    public function loginViaEmail(string $email,string $password,bool $rememberMe): AuthService;
    public function loginViaMobile(string $mobile,string $password,bool $rememberMe): AuthService;
    public function loginViaOtp(string $mobile,string $code,bool $rememberMe): AuthService;
    public function createToken(): string;
    public function storePassword(string $password): AuthService;
    public function updatePassword(string $currentPassword,string $newPassword): AuthService;
    public function verifyEmail();
    public function logout(?Request $request = null): AuthService;
    public function smsChannel(): SmsService;
}
