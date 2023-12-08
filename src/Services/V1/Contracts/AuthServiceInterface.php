<?php

namespace Callmeaf\Auth\Services\V1\Contracts;

use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Base\Services\V1\Contracts\BaseServiceInterface;

interface AuthServiceInterface extends BaseServiceInterface
{
    public function register(array $data): AuthService;
    public function registerViaMobile(string $mobile): AuthService;
    public function registerViaEmail(string $email): AuthService;
}
