<?php

use Illuminate\Support\Facades\Route;

Route::middleware(config('locky.middlewares'))
    ->namespace('\Dainsys\Locky\Http\Controllers')
    ->prefix('locky')
    ->name('locky.')
    ->group(function () {
        Route::get('/', 'DashboardController@index')->name('locky.dashboard');

        Route::get('users', 'LockyViewsController@users')->name('users.index');
        Route::get('roles', 'LockyViewsController@roles')->name('roles.index');
        Route::get('permissions', 'LockyViewsController@permissions')->name('permissions.index');
    });
