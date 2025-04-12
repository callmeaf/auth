<?php

namespace Callmeaf\Auth\App\Strategy;

use Callmeaf\Auth\App\Repo\Contracts\AuthRepoInterface;
use Callmeaf\Auth\App\Strategy\Api\V1\AuthEmailStrategy as ApiAuthEmailStrategy;
use Callmeaf\Auth\App\Strategy\Api\V1\AuthMobileStrategy as ApiAuthMobileStrategy;
use Callmeaf\Auth\App\Strategy\Admin\V1\AuthEmailStrategy as AdminAuthEmailStrategy;
use Callmeaf\Auth\App\Strategy\Admin\V1\AuthMobileStrategy as AdminAuthMobileStrategy;
use Callmeaf\Auth\App\Strategy\Contracts\AuthStrategyInterface;
use Callmeaf\Otp\App\Repo\Contracts\OtpRepoInterface;

class AuthStrategyFactory
{
    public static function create(string $identifier, AuthRepoInterface $authRepo, OtpRepoInterface $otpRepo): AuthStrategyInterface
    {
        if (str($identifier)->contains('@')) {
            return match (true) {
                isApiRequest() => new ApiAuthEmailStrategy(authRepo: $authRepo, otpRepo: $otpRepo),
                isAdminRequest() => new AdminAuthEmailStrategy(authRepo: $authRepo, otpRepo: $otpRepo),
                isWebRequest() => null,
            };
        }

        return match (true) {
            isApiRequest() => new ApiAuthMobileStrategy(authRepo: $authRepo, otpRepo: $otpRepo),
            isAdminRequest() => new AdminAuthMobileStrategy(authRepo: $authRepo, otpRepo: $otpRepo),
            isWebRequest() => null,
        };
    }
}
