<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->namespace('\Dainsys\Locky\Http\Controllers')
    ->prefix('admin')
    ->group(function () {
        Route::post('users/{user}/restore', 'UserController@restore')->name('users.restore');
        Route::resource('users', 'UserController')->except('create');

        Route::post('roles/{role}/restore', 'RoleController@restore')->name('roles.restore');
        Route::resource('roles', 'RoleController')->except('create');
    });
