<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->namespace('\Dainsys\Locky\Http\Controllers')->group(function () {
    Route::resource('users', 'UserController');
});
