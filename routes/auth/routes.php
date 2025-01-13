<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::get('/logout', 'App\Http\Controllers\Api\Auth\AuthController@logout');
    Route::get('validate-token-invite', 'App\Http\Controllers\Api\Auth\AuthController@validateTokenInvite');
});
