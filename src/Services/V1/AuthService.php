<?php

namespace Callmeaf\Auth\Services\V1;

use Callmeaf\Auth\Events\Registered;
use Callmeaf\Auth\Services\V1\Contracts\AuthServiceInterface;
use Callmeaf\Base\Services\V1\BaseService;
use Callmeaf\User\Http\Resources\V1\Api\UserCollection;
use Callmeaf\User\Http\Resources\V1\Api\UserResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
        $this->create([
            'mobile' => $mobile,
        ]);
        return $this;
    }

    public function registerViaEmail(string $email): AuthService
    {
        $this->create([
            'email' => $email,
        ]);
        return $this;
    }
}
