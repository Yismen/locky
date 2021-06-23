<?php

use Illuminate\Support\Facades\Route;

Route::middleware(config('locky.middlewares'))
    ->namespace('\Dainsys\Locky\Http\Controllers')
    ->prefix('locky')
    ->group(function () {
        Route::get('/', 'DashboardController@index')->name('locky.dashboard');
        Route::post('users/{user}/restore', 'UserController@restore')->name('users.restore');
        Route::resource('users', 'UserController')->except('create', 'show', 'destroy');

        Route::resource('roles', 'RoleController')->except('create', 'show', 'destroy');

        Route::resource('permissions', 'PermissionController')->except('create', 'show', 'destroy');
    });
