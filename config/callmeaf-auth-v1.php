<?php

use Callmeaf\Base\App\Enums\RequestType;

return [
    'model' => \Callmeaf\Auth\App\Models\Auth::class,
    'route_key_name' => 'mobile',
    'repo' => \Callmeaf\Auth\App\Repo\V1\AuthRepo::class,
    'resources' => [
        RequestType::API->value => [
            'resource' => \Callmeaf\Auth\App\Http\Resources\Api\V1\AuthResource::class,
            'resource_collection' => null
        ],
        RequestType::WEB->value => [
            'resource' => \Callmeaf\Auth\App\Http\Resources\Web\V1\AuthResource::class,
            'resource_collection' => null,
        ],
        RequestType::ADMIN->value => [
            'resource' => \Callmeaf\Auth\App\Http\Resources\Admin\V1\AuthResource::class,
            'resource_collection' => null,
        ],
    ],
    'events' => [
        RequestType::API->value => [
            \Callmeaf\Auth\App\Events\Api\V1\AuthLoggedIn::class => [
                // listeners
            ],
            \Callmeaf\Auth\App\Events\Api\V1\AuthLoggedOut::class => [
                // listeners
            ],
        ],
        RequestType::WEB->value => [
            \Callmeaf\Auth\App\Events\Web\V1\AuthLoggedIn::class => [
                // listeners
            ],
            \Callmeaf\Auth\App\Events\Web\V1\AuthLoggedOut::class => [
                // listeners
            ],
        ],
        RequestType::ADMIN->value => [
            \Callmeaf\Auth\App\Events\Admin\V1\AuthLoggedIn::class => [
                // listeners
            ],
            \Callmeaf\Auth\App\Events\Admin\V1\AuthLoggedOut::class => [
                // listeners
            ],
        ],
    ],
    'requests' => [
        RequestType::API->value => [
            'login' => \Callmeaf\Auth\App\Http\Requests\Api\V1\AuthLoginRequest::class,
            'user' => \Callmeaf\Auth\App\Http\Requests\Api\V1\AuthUserRequest::class,
            'logout' => \Callmeaf\Auth\App\Http\Requests\Api\V1\AuthLogoutRequest::class,
        ],
        RequestType::WEB->value => [
            'login' => \Callmeaf\Auth\App\Http\Requests\Web\V1\AuthLoginRequest::class,
            'user' => \Callmeaf\Auth\App\Http\Requests\Web\V1\AuthUserRequest::class,
            'logout' => \Callmeaf\Auth\App\Http\Requests\Web\V1\AuthLogoutRequest::class,
        ],
        RequestType::ADMIN->value => [
            'login' => \Callmeaf\Auth\App\Http\Requests\Admin\V1\AuthLoginRequest::class,
            'user' => \Callmeaf\Auth\App\Http\Requests\Admin\V1\AuthUserRequest::class,
            'logout' => \Callmeaf\Auth\App\Http\Requests\Admin\V1\AuthLogoutRequest::class,
        ],
    ],
    'controllers' => [
        RequestType::API->value => [
            'auth' => \Callmeaf\Auth\App\Http\Controllers\Api\V1\AuthController::class,
        ],
        RequestType::WEB->value => [
            'auth' => \Callmeaf\Auth\App\Http\Controllers\Web\V1\AuthController::class,
        ],
        RequestType::ADMIN->value => [
            'auth' => \Callmeaf\Auth\App\Http\Controllers\Admin\V1\AuthController::class,
        ],
    ],
    'routes' => [
        RequestType::API->value => [
            'prefix' => '',
            'as' => '',
            'middleware' => [],
        ],
        RequestType::WEB->value => [
            'prefix' => '',
            'as' => '',
            'middleware' => [],
        ],
        RequestType::ADMIN->value => [
            'prefix' => '',
            'as' => '',
            'middleware' => [],
        ],
    ],
    'enums' => [
        'status' => \Callmeaf\User\App\Enums\UserStatus::class,
        'type' => \Callmeaf\User\App\Enums\UserType::class,
    ],
];
