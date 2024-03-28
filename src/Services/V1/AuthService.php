<?php

namespace Callmeaf\Auth\Services\V1;

use Callmeaf\Auth\Events\Registered;
use Callmeaf\Auth\Events\VerifiedEmail;
use Callmeaf\Auth\Exceptions\CurrentPasswordIncorrectException;
use Callmeaf\Auth\Exceptions\UserAccountNotFoundException;
use Callmeaf\Auth\Exceptions\UserAlreadyHasPasswordException;
use Callmeaf\Auth\Services\V1\Contracts\AuthServiceInterface;
use Callmeaf\Base\Services\V1\BaseService;
use Callmeaf\Sms\Services\V1\SmsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService implements AuthServiceInterface
{
    public function __construct(?Builder $query = null, ?Model $model = null, ?Collection $collection = null, ?JsonResource $resource = null, ?ResourceCollection $resourceCollection = null, array $defaultData = [])
    {
        parent::__construct($query, $model, $collection, $resource, $resourceCollection, $defaultData);
        $this->query = app(config('callmeaf-auth.model'))->query();
        $this->resource = config('callmeaf-auth.model_resource');
        $this->resourceCollection = config('callmeaf-auth.model_resource_collection');
        $this->defaultData = config('callmeaf-auth.default_values');
    }

    public function register(array $data): AuthService
    {
        $this->create(data: [
            'first_name' => @$data['first_name'],
            'last_name' => @$data['last_name'],
            'national_code' => @$data['national_code'],
            'mobile' => @$data['mobile'],
            'email' => @$data['email'],
            'password' => @$data['password'],
        ]);
        Registered::dispatch($this->model);
        return $this;
    }

    public function registerViaMobile(string $mobile,?string $password = null): AuthService
    {
        $this->register(data: [
            'mobile' => $mobile,
            'password' => $password,
        ]);
        return $this;
    }

    public function registerViaEmail(string $email,?string $password = null): AuthService
    {
        $this->register(data: [
            'email' => $email,
            'password' => $password,
        ]);
        return $this;
    }

    public function loginViaEmail(string $email, string $password,bool $rememberMe): AuthService
    {
        $this->attempt(credentials: [
            'email' => $email,
            'password' => $password
        ],rememberMe: $rememberMe);

        return $this;
    }

    public function loginViaMobile(string $mobile, string $password, bool $rememberMe): AuthService
    {
        $this->attempt(credentials: [
            'mobile' => $mobile,
            'password' => $password,
        ],rememberMe: $rememberMe);

        return $this;
    }

    public function loginViaOtp(string $mobile, string $code, bool $rememberMe): AuthService
    {
        /* @var $otpService \Callmeaf\Otp\Services\V1\OtpService */
        $otpService = app(config('callmeaf-otp.service'));
        $result = $otpService->verifyCode(mobile: $mobile,code: $code);
        if($result) {
            $this->freshQuery()->where(column: 'mobile',valueOrOperation: $mobile)->first();
        }
       return $this;
    }

    public function createToken(): string
    {
        $model = $this->model;
        return $model->createToken($model->id)->plainTextToken;
    }

    public function storePassword(string $password): AuthService
    {
        if(!is_null($this->model->password)) {
            throw new UserAlreadyHasPasswordException();
        }
        $this->update([
            'password' => $password,
        ]);
        return $this;
    }

    public function updatePassword(string $currentPassword, string $newPassword): AuthService
    {
        if(!Hash::check(value: $currentPassword,hashedValue: $this->model->password)) {
            throw new CurrentPasswordIncorrectException();
        }
        $this->update(data: [
            'password' => $newPassword,
        ]);

        return $this;
    }

    public function verifyEmail(): AuthService
    {
        $model = $this->model;
        if (! $model->hasVerifiedEmail()) {
            $model->markEmailAsVerified();
            VerifiedEmail::dispatch($model);
        }
        $this->freshModel();
        return $this;
    }

    public function logout(?Request $request = null): AuthService
    {
        $request = $request ?? request();
        if(isApiRequest($request)) {
            $this->model->tokens()->delete();
        } else {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return $this;
    }

    public function smsChannel(): SmsService
    {
        return config('callmeaf-auth.sms_channel');
    }

    private function attempt(array $credentials,bool $rememberMe): void
    {
        if(!Auth::attempt($credentials,$rememberMe)) {
            throw new UserAccountNotFoundException();
        }
        $this->model = Auth::user();
    }
}
