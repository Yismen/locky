<?php

namespace Dainsys\Locky;

use App\User;
use Dainsys\Locky\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;

class LockyServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/locky.php' => config_path('locky.php')
        ], 'locky-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dainsys/locky')
        ], 'locky-views');

        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'locky');
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/locky.php',
            'locky'
        );
    }
}
