<?php

use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::get('/', 'App\Http\Controllers\Api\V1\User\UserController@index')
        ->middleware('permission:user_list');

    Route::get('/info', 'App\Http\Controllers\Api\V1\User\UserController@info')
        ->middleware('permission:user_list');

    Route::get('/{id}', 'App\Http\Controllers\Api\V1\User\UserController@show')
        ->middleware('permission:user_list');

    Route::post('/', 'App\Http\Controllers\Api\V1\User\UserController@store')
        ->middleware('permission:user_create');

    Route::put('/{id}/update-roles', 'App\Http\Controllers\Api\V1\User\UserController@updateRoles')
        ->middleware('permission:user_edit');

    Route::put('/update-profile', 'App\Http\Controllers\Api\V1\User\UserController@updateProfile')
        ->middleware('permission:user_edit');

    Route::put('/{id}', 'App\Http\Controllers\Api\V1\User\UserController@update')
        ->middleware('permission:user_edit');

    Route::patch('/change-role', 'App\Http\Controllers\Api\V1\User\UserController@changeRole')
        ->middleware('permission:user_edit');

    Route::delete('/{id}', 'App\Http\Controllers\Api\V1\User\UserController@destroy')
        ->middleware('permission:user_delete');

    Route::patch('/change-password', 'App\Http\Controllers\Api\V1\User\UserController@changePassword')
        ->middleware('permission:user_edit');
});
