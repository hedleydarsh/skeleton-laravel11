<?php

use Illuminate\Support\Facades\Route;

// unauth routes
include('unauth/routes.php');

Route::middleware(['auth:sanctum'])
    ->group(function () {
        //auth routes
        include('auth/routes.php');
        include('assessment/routes.php');
    });
