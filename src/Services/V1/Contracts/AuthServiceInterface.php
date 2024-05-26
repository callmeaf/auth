<?php

namespace Callmeaf\Auth\Services\V1\Contracts;

use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Services\V1\Contracts\BaseServiceInterface;
use Callmeaf\Sms\Services\V1\SmsService;
use Illuminate\Http\Request;

interface AuthServiceInterface extends BaseServiceInterface
{
    public function register(array $data,?array $events = []): AuthService;
    public function registerViaMobile(string $mobile,?string $password = null,?array $events = []): AuthService;
    public function registerViaEmail(string $email,?string $password = null,?array $events = []): AuthService;
    public function loginViaEmail(string $email,string $password,bool $rememberMe,?array $events = []): AuthService;
    public function loginViaMobile(string $mobile,string $password,bool $rememberMe,?array $events = []): AuthService;
    public function loginViaOtp(string $mobile,string $code,bool $rememberMe,?array $events = []): AuthService;
    public function createToken(): string;
    public function storePassword(string $password,?array $events = []): AuthService;
    public function updatePassword(string $currentPassword,string $newPassword,?array $events = []): AuthService;
    public function verifyEmail(?array $events = []);
    public function logout(?Request $request = null,?array $events = []): AuthService;
    public function smsChannel(): SmsService;
}
