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
use Illuminate\Validation\UnauthorizedException;

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
        $this->create([
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
        $this->register([
            'mobile' => $mobile,
        ]);
        return $this;
    }

    public function registerViaEmail(string $email,string $password): AuthService
    {
        $this->register([
            'email' => $email,
            'password' => $password,
        ]);
        return $this;
    }

    public function loginViaEmail(string $email, string $password,bool $rememberMe): AuthService
    {
        $this->attempt([
            'email' => $email,
            'password' => $password
        ]);

        return $this;
    }

    public function loginViaMobile(string $mobile, ?string $password, bool $rememberMe): AuthService
    {
        if($password) {
            $this->attempt([
                'mobile' => $mobile,
                'password' => $password,
            ]);
        }


        return $this;
    }

    public function createToken(): string
    {
        $model = $this->model;
        return $model->createToken($model->id)->plainTextToken;
    }


    private function attempt(array $credentials): void
    {
        if(!Auth::attempt($credentials)) {
            throw new UserAccountNotFoundException();
        }
        $this->model = Auth::user();
    }
}
