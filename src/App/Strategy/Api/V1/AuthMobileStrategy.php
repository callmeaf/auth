<?php

namespace Callmeaf\Auth\App\Strategy\Api\V1;

use Callmeaf\Auth\App\Http\Resources\Api\V1\AuthResource;
use Callmeaf\Auth\App\Repo\Contracts\AuthRepoInterface;
use Callmeaf\Auth\App\Strategy\Contracts\AuthStrategyInterface;
use Callmeaf\Otp\App\Repo\Contracts\OtpRepoInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

/**
 * @extends AuthStrategyInterface<AuthResource>
 */
class AuthMobileStrategy implements AuthStrategyInterface
{
    public function __construct(public AuthRepoInterface $authRepo, public OtpRepoInterface $otpRepo)
    {
    }

    public function sendOtp(string $identifier): string
    {
        return $this->otpRepo->create(data: [
            'identifier' => $identifier,
        ]);
    }

    public function verifyOtp(string $identifier, string $code): bool
    {
        $result = $this->otpRepo->verifyCode(identifier: $identifier, code: $code);

        if ($result) {
            $this->otpRepo->expireCode(code: $code);
        }

        return $result;
    }

    public function createUser(string $identifier)
    {
        return $this->authRepo->trashed(false)->getQuery()->where('mobile', $identifier)->firstOr(function () use ($identifier) {
            return $this->authRepo->getQuery()->create([
                'mobile' => $identifier,
                'status' => $this->authRepo->config['user_default_status'],
                'type' => $this->authRepo->config['user_default_type'],
            ]);
        });
    }

    public function attempt(string $identifier, bool $remember = false)
    {
        $user = $this->authRepo->findBy(column: 'mobile', value: $identifier);
        return Auth::loginUsingId($user->resource->id, remember: $remember);
    }

    public function attemptViaPassword(string $identifier, string $password, bool $remember = false): bool
    {
        return Auth::attempt([
            'mobile' => $identifier,
            'password' => $password
        ],remember: $remember);
    }
}
