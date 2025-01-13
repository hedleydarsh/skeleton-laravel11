<?php

use Illuminate\Support\Facades\Route;

Route::prefix('assessments')->group(function () {
    Route::get('/', 'App\Http\Controllers\Api\V1\Assessment\AssessmentController@index')
        ->middleware('permission:assessment_list');

    Route::get('/{id}', 'App\Http\Controllers\Api\V1\Assessment\AssessmentController@show')
        ->middleware('permission:assessment_list');

    Route::post('/', 'App\Http\Controllers\Api\V1\Assessment\AssessmentController@store')
        ->middleware('permission:assessment_create');

    Route::put('/{id}', 'App\Http\Controllers\Api\V1\Assessment\AssessmentController@update')
        ->middleware('permission:assessment_edit');

    Route::delete('/{id}', 'App\Http\Controllers\Api\V1\Assessment\AssessmentController@destroy')
        ->middleware('permission:assessment_delete');
});
