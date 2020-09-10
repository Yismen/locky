<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(config('locky.middlewares'))
    ->namespace('\Dainsys\Locky\Http\Controllers')
    ->prefix('locky')
    ->group(function () {
        Route::post('users/{user}/restore', 'UserController@restore')->name('users.restore');
        Route::resource('users', 'UserController')->except('create');

        Route::resource('roles', 'RoleController')->except('create');

        Route::resource('permissions', 'PermissionController')->except('create');
    });
