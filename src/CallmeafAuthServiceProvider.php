<?php

namespace Callmeaf\Auth;

use Illuminate\Support\ServiceProvider;

class CallmeafAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoute();
        $this->registerConfig();
        $this->registerMigration();
    }

    private function registerRoute()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    private function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/callmeaf-auth.php','callmeaf-auth');
        $this->publishes([
            __DIR__ . '/../config/callmeaf-auth.php' => config_path('callmeaf-user.php'),
        ],'callmeaf-auth-config');
    }

    private function registerMigration()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations')
        ],'callmeaf-auth-migrations');
    }
}
