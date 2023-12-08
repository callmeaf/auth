<?php

namespace Callmeaf\Auth;

use Callmeaf\Auth\Events\Registered;
use Callmeaf\Auth\Listeners\SendWelcomeSmsToUser;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class CallmeafAuthServiceProvider extends ServiceProvider
{
    private const CONFIGS_DIR = __DIR__ . '/../config';
    private const ROUTES_DIR = __DIR__ . '/../routes';

    public function boot(): void
    {
        $this->registerConfig();
        $this->registerRoute();
        $this->registerEvents();
    }

    private function registerConfig(): void
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

    private function registerEvents(): void
    {
        Event::listen(Registered::class,function(Registered $event) {
            (new SendWelcomeSmsToUser())->handle($event);
        });
    }
}
