<?php

namespace Callmeaf\Auth\App\Repo\V1;

use Callmeaf\Auth\App\Exceptions\InvalidCredentialsAuthenticateException;
use Callmeaf\Auth\App\Exceptions\InvalidOtpCodeException;
use Callmeaf\Auth\App\Exceptions\UserAccountHasNoStatusException;
use Callmeaf\Auth\App\Exceptions\UserAccountIsInActiveException;
use Callmeaf\Auth\App\Exceptions\UserAccountIsPendingException;
use Callmeaf\Auth\App\Exceptions\UserAccountSoftDeletedException;
use Callmeaf\Auth\App\Repo\Contracts\AuthRepoInterface;
use Callmeaf\Auth\App\Strategy\AuthStrategyFactory;
use Callmeaf\Auth\App\Strategy\Contracts\AuthStrategyInterface;
use Callmeaf\Base\App\Repo\V1\CoreRepo;
use Callmeaf\Otp\App\Repo\Contracts\OtpRepoInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AuthRepo extends CoreRepo implements AuthRepoInterface
{
    public function login(string $identifier, string $code, bool $remember = false)
    {
        $authStrategy = $this->strategy(identifier: $identifier);
        $result = $authStrategy->verifyOtp(identifier: $identifier, code: $code);

        if (!$result) {
            throw new InvalidOtpCodeException();
        }

        $user = $authStrategy->createUser(identifier: $identifier);
        $this->checkUserStatus(user: $user);

        $user = $authStrategy->attempt(identifier: $identifier, remember: $remember);
        $user->token = $this->newToken();

        return $this->toResource(model: $user);
    }

    public function loginViaPassword(string $identifier, string $password, bool $remember = false)
    {
        $authStrategy = $this->strategy(identifier: $identifier);
        if( ! $authStrategy->attemptViaPassword(identifier: $identifier,password: $password,remember: $remember)) {
            throw new InvalidCredentialsAuthenticateException();
        }

        $user = $this->user()->resource;
        $user->token = $this->newToken();

        return $this->toResource(model: $user);
    }

    public function newToken(): string
    {
        $user = Auth::user();
        return $user->createToken(name: $user->getKey())->plainTextToken;
    }

    public function user()
    {
        return $this->toResource(model: Auth::user());
    }

    public function logout(): int
    {
        return Auth::user()->tokens()->delete();
    }

    public function checkUserStatus($user): bool
    {
        return match (true) {
            $user->isInActive() => throw new UserAccountIsInActiveException(),
            $user->isPending() => throw new UserAccountIsPendingException(),
            $user->trashed() => throw new UserAccountSoftDeletedException(),
            $user->isActive() => true,
            default => throw new UserAccountHasNoStatusException(),
        };
    }

    public function updateProfile(array $data,?UploadedFile $image = null)
    {
        $user = $this->user();
        $user->resource->update($data);

        if($image) {
            $this->addMedia(id: $user,file: $image);
        }

        return $this->toResource($user->resource->fresh()->loadMissing([
            'image'
        ]));
    }

    public function updatePassword(string $password, string $code)
    {
        $user = $this->user()->resource;

        $authStrategy = $this->strategy(identifier: $user->identifier());
        $result = $authStrategy->verifyOtp(identifier: $user->identifier(),code: $code);

        if (!$result) {
            throw new InvalidOtpCodeException();
        }

        $user->update([
            'password' => $password,
        ]);

        return $this->toResource($user->fresh());
    }

    public function acceptTerms(bool $value)
    {
        $user = $this->user()->resource;
        $user->update([
            'accepted_terms' => $value,
        ]);

        return $this->toResource($user->fresh());
    }

    private function strategy(string $identifier): AuthStrategyInterface
    {
        // TODO: implements auth method via setting package
        return AuthStrategyFactory::create(identifier: $identifier, authRepo: app(AuthRepoInterface::class), otpRepo: app(OtpRepoInterface::class));
    }
}
