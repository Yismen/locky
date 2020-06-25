<?php

namespace Dainsys\Locky\Tests;

use App\User;
use Dainsys\Locky\LockyServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(realpath(dirname(__DIR__) . '/../../database/factories'));
        $this->loadLaravelMigrations();
        $this->artisan('migrate');

        Route::get('/login')->name('login');
        Route::post('/logout')->name('logout');
    }

    /**
     * Executed after each test.
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Load the command service provider.
     *
     * @param \Illuminate\Foundationlication $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            LockyServiceProvider::class,
            PermissionServiceProvider::class
        ];
    }

    /**
     * Create a model factory
     *
     * @param Model $model_string
     * @param integer $amount
     * @param array $attributes
     * @return model instance
     */
    protected function create($model_string, int $amount = null, array $attributes = [])
    {
        return factory($model_string, $amount)->create($attributes);
    }

    protected function user($attributes = [])
    {
        return factory(User::class)->create($attributes);
    }

    protected function authorizedUser()
    {
        return factory(User::class)->create(['email' => config('locky.super_user_email')]);
    }
}
