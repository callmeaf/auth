<?php

namespace Callmeaf\Auth;

use Callmeaf\Auth\App\Repo\Contracts\AuthRepoInterface;
use Callmeaf\Base\CallmeafServiceProvider;
use Callmeaf\Base\Contracts\ServiceProvider\HasConfig;
use Callmeaf\Base\Contracts\ServiceProvider\HasEvent;
use Callmeaf\Base\Contracts\ServiceProvider\HasLang;
use Callmeaf\Base\Contracts\ServiceProvider\HasRepo;
use Callmeaf\Base\Contracts\ServiceProvider\HasRoute;

class CallmeafAuthServiceProvider extends CallmeafServiceProvider implements HasConfig, HasEvent, HasRoute, HasRepo, HasLang
{
    protected function serviceKey(): string
    {
        return 'auth';
    }

    public function repo(): string
    {
        return AuthRepoInterface::class;
    }
}
