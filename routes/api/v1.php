<?php

use App\Api\V1\Processes\Controllers\PerformProcessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::patch('/orders/{order}/items/{item}/processes/{process}/perform', PerformProcessController::class)->name('processes.perform')->middleware(\App\Http\Middleware\EnsureProcessCanBePerformed::class);
