<?php

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/register', 'App\Http\Controllers\Api\V1\Auth\AuthController@register');
Route::post('auth/login', 'App\Http\Controllers\Api\V1\Auth\AuthController@login');
Route::post('auth/forgot-password', 'App\Http\Controllers\Api\V1\Auth\AuthController@forgotPassword');
Route::post('auth/reset-password', 'App\Http\Controllers\Api\V1\Auth\AuthController@resetPassword');

Route::get('/email/verify', function () {
    return response()->json(['message' => 'Verifique seu e-mail para verificar sua conta.'], 409);
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', 'App\Http\Controllers\Api\V1\Auth\AuthController@confirmRegister')
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('/email/resend', 'App\Http\Controllers\Api\V1\Auth\AuthController@resendConfirmRegister')
    ->middleware('throttle:6,1')
    ->name('verification.resend');

Route::post('create-logo', function (Request $request) {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $path = uploadImage(request()->image, 'icons');
    $url = env('AWS_URL') . $path;
    return response()->json(['url' => $url]);
});

Route::get('/preview-email', function () {
    $teams = Team::factory(1)->create();
    return view('emails.invite_management_team', [
        'team' => $teams->first(),
    ]);
});
