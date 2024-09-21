<?php

namespace Callmeaf\Auth\Http\Controllers\V1\Api;

use Callmeaf\Auth\Events\Registered;
use Callmeaf\Auth\Events\RegisteredViaEmail;
use Callmeaf\Auth\Events\RegisteredViaMobile;
use Callmeaf\Auth\Http\Requests\V1\Api\RegisterRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\RegisterViaEmailRequest;
use Callmeaf\Auth\Http\Requests\V1\Api\RegisterViaMobileRequest;
use Callmeaf\Auth\Services\V1\AuthService;
use Callmeaf\Auth\Utilities\V1\Api\Register\RegisterResources;
use Callmeaf\Base\Http\Controllers\V1\Api\ApiController;

class RegisterController extends ApiController
{
    protected AuthService $authService;
    protected RegisterResources $registerResources;
    public function __construct()
    {
        app(config('callmeaf-auth.middlewares.register'))($this);
        $this->authService = app(config('callmeaf-auth.service'));
        $this->registerResources = app(config('callmeaf-auth.resources.register'));
    }
    public function register(RegisterRequest $request)
    {
        try {
            $resources = $this->registerResources->register();
            $user = $this->authService
                ->register(data: $request->validated(),events: [
                    Registered::class,
                ])
                ->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'user' => $user
            ],__('callmeaf-base::v1.successful_created',[
                'title' => $user->fullName,
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([]);
        }
    }

    public function registerViaMobile(RegisterViaMobileRequest $request)
    {
        try {
            $resources = $this->registerResources->registerViaMobile();
            $user = $this->authService
                ->registerViaMobile(mobile: $request->get('mobile'),events: [
                    RegisteredViaMobile::class
                ])
                ->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
             return apiResponse([
                 'user' => $user,
             ],__('callmeaf-base::v1.successful_created',[
                 'title' => $user->mobile,
             ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }

    }

    public function registerViaEmail(RegisterViaEmailRequest $request)
    {
        try {
            $resources = $this->registerResources->registerViaEmail();
            $user = $this->authService
                ->registerViaEmail(email: $request->get('email'),password: $request->get('password'),events: [
                    RegisteredViaEmail::class
                ])
                ->getModel(asResource: true,attributes: $resources->attributes(),relations: $resources->relations());
            return apiResponse([
                'user' => $user,
            ],__('callmeaf-base::v1.successful_created',[
                'title' => $user->email,
            ]));
        } catch (\Exception $exception) {
            report($exception);
            return apiResponse([],$exception);
        }
    }
}
