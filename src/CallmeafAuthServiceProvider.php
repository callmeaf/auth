<?php

namespace Callmeaf\Auth;

use Illuminate\Support\ServiceProvider;

class CallmeafAuthServiceProvider extends ServiceProvider
{
    private const CONFIGS_DIR = __DIR__ . '/../config';
    private const ROUTES_DIR = __DIR__ . '/../routes';
    public function boot()
    {
        $this->registerConfig();
        $this->registerRoute();
    }

    private function registerConfig()
    {
        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-auth.php','callmeaf-auth');
        $this->publishes([
            self::CONFIGS_DIR . '/callmeaf-auth.php' => config_path('callmeaf-user.php'),
        ],'callmeaf-auth-config');
    }

    private function registerRoute()
    {
        $this->loadRoutesFrom(self::ROUTES_DIR . '/v1/api.php');
    }
}
