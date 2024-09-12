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

    public function register(array $data,?array $events = []): self
    {
        $this->create(data: [
            'first_name' => @$data['first_name'],
            'last_name' => @$data['last_name'],
            'national_code' => @$data['national_code'],
            'mobile' => @$data['mobile'],
            'email' => @$data['email'],
            'password' => @$data['password'],
        ]);
        $this->eventsCaller($events);
        return $this;
    }

    public function registerViaMobile(string $mobile,?string $password = null,?array $events = []): self
    {
        $this->register(data: [
            'mobile' => $mobile,
            'password' => $password,
        ]);
        $this->eventsCaller($events);
        return $this;
    }

    public function registerViaEmail(string $email,?string $password = null,?array $events = []): self
    {
        $this->register(data: [
            'email' => $email,
            'password' => $password,
        ]);
        $this->eventsCaller($events);
        return $this;
    }

    public function loginViaEmail(string $email, string $password,bool $rememberMe,?array $events = []): self
    {
        $this->attempt(credentials: [
            'email' => $email,
            'password' => $password
        ],rememberMe: $rememberMe);
        $this->eventsCaller($events);
        return $this;
    }

    public function loginViaMobile(string $mobile, string $password, bool $rememberMe,?array $events = []): self
    {
        $this->attempt(credentials: [
            'mobile' => $mobile,
            'password' => $password,
        ],rememberMe: $rememberMe);
        $this->eventsCaller($events);
        return $this;
    }

    public function loginViaOtp(string $mobile, string $code, bool $rememberMe,?array $events = []): self
    {
        /* @var $otpService \Callmeaf\Otp\Services\V1\OtpService */
        $otpService = app(config('callmeaf-otp.service'));
        $result = $otpService->verifyCode(mobile: $mobile,code: $code);
        if($result) {
            $this->freshQuery()->where(column: 'mobile',valueOrOperation: $mobile)->first();
        }
        $this->eventsCaller($events);
       return $this;
    }

    public function createToken(): string
    {
        $model = $this->model;
        return $model->createToken($model->id)->plainTextToken;
    }

    public function storePassword(string $password,?array $events = []): self
    {
        if(!is_null($this->model->password)) {
            throw new UserAlreadyHasPasswordException();
        }
        $this->update([
            'password' => $password,
        ]);
        $this->eventsCaller($events);
        return $this;
    }

    public function updatePassword(string $currentPassword, string $newPassword,?array $events = []): self
    {
        if(!Hash::check(value: $currentPassword,hashedValue: $this->model->password)) {
            throw new CurrentPasswordIncorrectException();
        }
        $this->update(data: [
            'password' => $newPassword,
        ]);
        $this->eventsCaller($events);
        return $this;
    }

    public function verifyEmail(?array $events = []): self
    {
        $model = $this->model;
        if (! $model->hasVerifiedEmail()) {
            $model->markEmailAsVerified();
            $this->eventsCaller($events);
        }
        $this->freshModel();
        $this->eventsCaller($events);
        return $this;
    }

    public function logout(?Request $request = null,?array $events = []): self
    {
        $request = $request ?? request();
        if(isApiRequest($request)) {
            $this->model->tokens()->delete();
        } else {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        $this->eventsCaller($events);
        return $this;
    }

    public function smsChannel(): SmsService
    {
        return app(config('callmeaf-auth.sms_channel'));
    }

    protected function attempt(array $credentials,bool $rememberMe): void
    {
        if(!Auth::attempt($credentials,$rememberMe)) {
            throw new UserAccountNotFoundException();
        }
        $this->model = Auth::user();
    }
}
