<?php

namespace Callmeaf\Auth\Services\V1;

use Callmeaf\Auth\Events\Registered;
use Callmeaf\Auth\Exceptions\UserAccountNotFoundException;
use Callmeaf\Auth\Services\V1\Contracts\AuthServiceInterface;
use Callmeaf\Base\Services\V1\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

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

    public function registerViaMobile(string $mobile): AuthService
    {
        $this->register(data: [
            'mobile' => $mobile,
        ]);
        return $this;
    }

    public function registerViaEmail(string $email,string $password): AuthService
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
            $this->freshQuery()->where('mobile',$mobile)->first();
        }
       return $this;
    }

    public function createToken(): string
    {
        $model = $this->model;
        return $model->createToken($model->id)->plainTextToken;
    }


    private function attempt(array $credentials,bool $rememberMe): void
    {
        if(!Auth::attempt($credentials,$rememberMe)) {
            throw new UserAccountNotFoundException();
        }
        $this->model = Auth::user();
    }
}
