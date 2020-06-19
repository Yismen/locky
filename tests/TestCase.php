<?php

namespace Dainsys\Locky\Tests;

use App\User;
use Dainsys\Locky\LockyServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Support\Facades\Route;

class TestCase extends OrchestraTestCase
{
    /**
     * The log directory path.
     *
     * @var string
     */

    public $user;

    /**
     * Executed before each test.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(realpath(dirname(__DIR__) . '/../../database/factories'));
        $this->loadLaravelMigrations();
        $this->artisan('migrate');
        $this->user = factory(User::class)->create();

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
        return [LockyServiceProvider::class];
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

    protected function authorizedUser()
    {
        return $this->create(User::class, null, ['email' => config('locky.super_user')]);
    }
}
