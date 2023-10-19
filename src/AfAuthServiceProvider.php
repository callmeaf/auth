<?php

namespace Af\Auth;

use Illuminate\Support\ServiceProvider;

class AfAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->mergeConfigFrom(__DIR__.'/config/af-auth.php','af-auth');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([
            __DIR__.'/config/af-auth.php' => config_path('af-auth.php'),
        ],'af-auth-config');

        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations')
        ],'af-auth-migrations');
    }
}
