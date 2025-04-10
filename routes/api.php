<?php

use App\Http\Controllers\TaskApiController;
use Illuminate\Support\Facades\Route;


Route::prefix('tasks')->controller(TaskApiController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/{id}/status', 'changeStatus')->name('tasks.status');
    Route::get('/search', 'searchTasks')->name('tasks.search');
});
