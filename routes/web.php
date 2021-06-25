<?php

use Illuminate\Support\Facades\Route;

Route::middleware(config('locky.middlewares'))
    ->namespace('\Dainsys\Locky\Http\Controllers')
    ->prefix('locky')
    ->name('locky.')
    ->group(function () {
        Route::get('/', 'DashboardController@index')->name('locky.dashboard');
        Route::post('users/{user}/restore', 'UserController@restore')->name('users.restore');
        Route::get('users', 'UserController@index')->name('users.index');
        Route::get('roles', 'RoleController@index')->name('roles.index');
        Route::get('permissions', 'PermissionController@index')->name('permissions.index');
    });
