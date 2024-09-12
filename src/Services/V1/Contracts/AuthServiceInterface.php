<?php

namespace Callmeaf\Auth\Services\V1\Contracts;

use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Services\V1\Contracts\BaseServiceInterface;
use Callmeaf\Sms\Services\V1\SmsService;
use Illuminate\Http\Request;

interface AuthServiceInterface extends BaseServiceInterface
{
    public function register(array $data,?array $events = []): self;
    public function registerViaMobile(string $mobile,?string $password = null,?array $events = []): self;
    public function registerViaEmail(string $email,?string $password = null,?array $events = []): self;
    public function loginViaEmail(string $email,string $password,bool $rememberMe,?array $events = []): self;
    public function loginViaMobile(string $mobile,string $password,bool $rememberMe,?array $events = []): self;
    public function loginViaOtp(string $mobile,string $code,bool $rememberMe,?array $events = []): self;
    public function createToken(): string;
    public function storePassword(string $password,?array $events = []): self;
    public function updatePassword(string $currentPassword,string $newPassword,?array $events = []): self;
    public function verifyEmail(?array $events = []);
    public function logout(?Request $request = null,?array $events = []): self;
    public function smsChannel(): SmsService;
}
