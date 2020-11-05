<?php

namespace Dainsys\Locky;

use App\User;
use Dainsys\Locky\Policies\SuperUserPolicy;
use Dainsys\Locky\Tests\Mocks\UserMock;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class LockyServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => SuperUserPolicy::class,
        Role::class => SuperUserPolicy::class,
        Permission::class => SuperUserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPublishables()
            ->bootConfigurations()
            ->registerPolicies();

        Gate::define('is-super-user', function ($user) {
            return $user->email === config('locky.super_user_email');
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/locky.php',
            'locky'
        );
    }

    protected function registerPublishables()
    {
        $this->publishes([
            __DIR__ . '/../config/locky.php' => config_path('locky.php')
        ], 'locky-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dainsys/locky')
        ], 'locky-views');

        $this->publishes([
            __DIR__ . '/../public/vendor/locky' => public_path('vendor/dainsys/locky'),
        ], 'locky-public');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/dainsys/locky')
        ], 'locky-lang');

        return $this;
    }

    protected function bootConfigurations()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'locky');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'locky');
        if (config('locky.with_migrations') === true) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');

        return $this;
    }
}
