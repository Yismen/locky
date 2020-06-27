<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->namespace('\Dainsys\Locky\Http\Controllers')
    ->prefix('admin')
    ->group(function () {
        Route::post('users/{user}/restore', 'UserController@restore')->name('users.restore');
        Route::resource('users', 'UserController')->except('create');

        Route::resource('roles', 'RoleController')->except('create');

        Route::resource('permissions', 'PermissionController')->except('create');
    });
