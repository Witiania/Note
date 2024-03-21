<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\NotebookController::class)->group(function() {
    Route::get('/v1/notebook', 'show');
    Route::post('/v1/notebook', 'create');
    Route::get('/v1/notebook/{id}', 'showOne');
    Route::patch('/v1/notebook/{id}', 'update');
    Route::delete('/v1/notebook/{id}', 'delete');
});
