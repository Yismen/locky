<?php

namespace Dainsys\Locky;

use Dainsys\Locky\Contracts\UserContract as User;
use Dainsys\Locky\Models\Permission;
use Dainsys\Locky\Models\Role;
use Dainsys\Locky\Policies\SuperUserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;

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
        $this
            ->bootModelBindings()
            ->bootPublishables()
            ->bootLivewireComponents()
            ->bootConfigurations();

        Gate::define('is-super-user', function ($user) {
            return $user->email === config('locky.super_user_email');
        });
    }

    public function register()
    {
        $this->registerPolicies();

        $this->mergeConfigFrom(
            __DIR__ . '/../config/locky.php',
            'locky'
        );
    }

    protected function bootModelBindings()
    {
        if ($config = $this->app->config['locky.models']) {
            $this->app->bind(User::class, $config['user']);
        }


        return $this;
    }

    protected function bootPublishables()
    {
        $this->publishes([
            __DIR__ . '/../config/locky.php' => config_path('locky.php')
        ], 'locky-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/locky')
        ], 'locky-views');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/locky')
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

    protected function bootLivewireComponents()
    {
        Livewire::component('locky::permission.permission-index', \Dainsys\Locky\Http\Livewire\Permission\PermissionIndex::class);
        Livewire::component('locky::permission.permission-form', \Dainsys\Locky\Http\Livewire\Permission\PermissionForm::class);
        Livewire::component('locky::permission.permission-detail', \Dainsys\Locky\Http\Livewire\Permission\PermissionDetail::class);

        Livewire::component('locky::user.user-index', \Dainsys\Locky\Http\Livewire\User\UserIndex::class);
        Livewire::component('locky::user.user-form', \Dainsys\Locky\Http\Livewire\User\UserForm::class);
        Livewire::component('locky::user.user-detail', \Dainsys\Locky\Http\Livewire\User\UserDetail::class);

        Livewire::component('locky::role.role-index', \Dainsys\Locky\Http\Livewire\Role\RoleIndex::class);
        Livewire::component('locky::role.role-form', \Dainsys\Locky\Http\Livewire\Role\RoleForm::class);
        Livewire::component('locky::role.role-detail', \Dainsys\Locky\Http\Livewire\Role\RoleDetail::class);

        return $this;
    }
}
