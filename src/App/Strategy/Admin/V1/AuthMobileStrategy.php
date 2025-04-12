<?php

namespace Callmeaf\Auth\App\Strategy\Admin\V1;

use Callmeaf\Auth\App\Http\Resources\Api\V1\AuthResource;
use Callmeaf\Auth\App\Repo\Contracts\AuthRepoInterface;
use Callmeaf\Auth\App\Strategy\Contracts\AuthStrategyInterface;
use Callmeaf\Otp\App\Repo\Contracts\OtpRepoInterface;
use Illuminate\Support\Facades\Auth;

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
            ]);
        });
    }

    public function attempt(string $identifier, bool $remember = false)
    {
        $user = $this->authRepo->findBy(column: 'mobile', value: $identifier);
        return Auth::loginUsingId($user->resource->id, remember: $remember);
    }
}
