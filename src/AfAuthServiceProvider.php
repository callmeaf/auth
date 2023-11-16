<?php

namespace Callmeaf\Auth;

use Illuminate\Support\ServiceProvider;

class AfAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->mergeConfigFrom(__DIR__ . '/config/callmeaf-auth.php','af-auth');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([
            __DIR__ . '/config/callmeaf-auth.php' => config_path('callmeaf-auth.php'),
        ],'callmeaf-auth-config');

        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations')
        ],'callmeaf-auth-migrations');
    }
}
