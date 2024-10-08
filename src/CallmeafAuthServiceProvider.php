<?php

namespace Callmeaf\Auth;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class CallmeafAuthServiceProvider extends ServiceProvider
{
    private const CONFIGS_DIR = __DIR__ . '/../config';
    private const CONFIGS_KEY = 'callmeaf-auth';
    private const CONFIG_GROUP = 'callmeaf-auth-config';
    private const PASSWORD_CONFIGS_DIR = __DIR__ . '/../config';
    private const PASSWORD_CONFIGS_KEY = 'callmeaf-password';
    private const PASSWORD_CONFIG_GROUP = 'callmeaf-password-config';

    private const ROUTES_DIR = __DIR__ . '/../routes';
    private const DATABASE_DIR = __DIR__ . '/../database';
    private const DATABASE_GROUPS = 'callmeaf-user-migrations';
    private const RESOURCES_DIR = __DIR__ . '/../resources';
    private const VIEWS_NAMESPACE = 'callmeaf-auth';
    private const VIEWS_GROUP = 'callmeaf-auth-views';

    private const LANG_DIR = __DIR__ . '/../lang';
    private const LANG_NAMESPACE = 'callmeaf-auth';
    private const LANG_GROUP = 'callmeaf-auth-lang';

    public function boot(): void
    {
        $this->registerConfig();
        $this->registerRoute();
        $this->registerMigration();
        $this->registerEvents();
        $this->registerViews();
        $this->registerLang();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(self::CONFIGS_DIR . '/callmeaf-auth.php',self::CONFIGS_KEY);
        $this->publishes([
            self::CONFIGS_DIR . '/callmeaf-auth.php' => config_path('callmeaf-auth.php'),
        ],self::CONFIG_GROUP);

        $this->mergeConfigFrom(self::PASSWORD_CONFIGS_DIR . '/callmeaf-password.php',self::PASSWORD_CONFIGS_KEY);
        $this->publishes([
            self::PASSWORD_CONFIGS_DIR . '/callmeaf-password.php' => config_path('callmeaf-password.php'),
        ],self::PASSWORD_CONFIG_GROUP);
    }

    private function registerRoute(): void
    {
        $this->loadRoutesFrom(self::ROUTES_DIR . '/v1/api.php');
        $this->loadRoutesFrom(self::ROUTES_DIR . '/v1/web.php');
    }

    private function registerMigration(): void
    {
        $this->loadMigrationsFrom(self::DATABASE_DIR . '/migrations');
        $this->publishes([
            self::DATABASE_DIR . '/migrations' => database_path('migrations'),
        ],self::DATABASE_GROUPS);
    }

    private function registerEvents(): void
    {
        foreach (config('callmeaf-auth.events') as $event => $listeners) {
            Event::listen($event,function($event) use ($listeners) {
                foreach($listeners as $listener) {
                    app($listener)->handle($event);
                }
            });
        }

        foreach (config('callmeaf-password.events') as $event => $listeners) {
            Event::listen($event,function($event) use ($listeners) {
                foreach($listeners as $listener) {
                    app($listener)->handle($event);
                }
            });
        }
    }

    private function registerViews(): void
    {
        $this->loadViewsFrom(self::RESOURCES_DIR . '/views',self::VIEWS_NAMESPACE);
        $this->publishes([
            self::RESOURCES_DIR . '/views' => resource_path('views/vendor/callmeaf-auth'),
        ],self::VIEWS_GROUP);

    }

    private function registerLang(): void
    {
        $langPathFromVendor = lang_path('vendor/callmeaf/auth');
        if(is_dir($langPathFromVendor)) {
            $this->loadTranslationsFrom($langPathFromVendor,self::LANG_NAMESPACE);
        } else {
            $this->loadTranslationsFrom(self::LANG_DIR,self::LANG_NAMESPACE);
        }
        $this->publishes([
            self::LANG_DIR => $langPathFromVendor,
        ],self::LANG_GROUP);
    }
}
