<?php

use App\Http\Controllers\EventController;

Route::prefix('events')->group(function () {
    Route::get('/',        [EventController::class, 'index']);
    Route::post('/',       [EventController::class, 'insert']);
    Route::get('/{id}',    [EventController::class, 'show']);
    Route::put('/{id}',    [EventController::class, 'update']);
    Route::delete('/{id}', [EventController::class, 'delete']);
});
