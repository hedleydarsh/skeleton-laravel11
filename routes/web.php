<?php

use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::post('auth/register', function () {
    return response()->json(['message' => 'Verifique seu e-mail para verificar sua conta.'], 409);
});
