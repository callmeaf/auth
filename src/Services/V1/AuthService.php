<?php

namespace Callmeaf\Auth\Services\V1;

use Callmeaf\Auth\Services\V1\Contracts\AuthServiceInterface;
use Callmeaf\Base\CallmeafBaseServiceProvider;
use Callmeaf\Base\Services\V1\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AuthService extends BaseService implements AuthServiceInterface
{
    public function __construct(?Builder $query = null, ?Model $model = null, ?Collection $collection = null,protected array $defaultData = [])
    {
        CallmeafBaseServiceProvider::class;
        parent::__construct($query, $model, $collection);
        $this->query = app(config('af-auth.models.auth'))->query();
        $this->defaultData = config('af-auth.default_values');
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
        return $this;
    }
}
