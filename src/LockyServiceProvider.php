<?php

namespace Dainsys\Locky;

use App\User;
use Dainsys\Locky\Policies\SuperUserPolicy;
use Dainsys\Locky\View\Components\InputField;
use Dainsys\Locky\View\Components\InputFieldAddon;
use Dainsys\Locky\View\Components\InputLabel;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
            ->registerViewComponents()
            ->registerPolicies();

        require_once(__DIR__ . '/../helpers/helpers.php');
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

        return $this;
    }

    protected function bootConfigurations()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'locky');
        if (config('locky.with_migrations') === true) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');

        return $this;
    }

    protected function registerViewComponents()
    {
        Blade::component('input-label', InputLabel::class);
        Blade::component('input-field', InputField::class);
        Blade::component('input-field-addon', InputFieldAddon::class);

        return $this;
    }
}
