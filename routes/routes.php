<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

if (config('locky.with_auth_routes') == true) {
    Auth::routes();
}

Route::middleware(config('locky.middlewares'))
    ->namespace('\Dainsys\Locky\Http\Controllers')
    ->prefix('admin')
    ->group(function () {
        Route::post('users/{user}/restore', 'UserController@restore')->name('users.restore');
        Route::resource('users', 'UserController')->except('create');

        Route::resource('roles', 'RoleController')->except('create');

        Route::resource('permissions', 'PermissionController')->except('create');
    });
