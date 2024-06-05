<?php

use App\Api\V1\Processes\Controllers\PerformProcessController;
use App\Http\Middleware\EnsureProcessCanBePerformed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/orders/{order}/items/{item}/processes/{process}/perform', PerformProcessController::class)->middleware(EnsureProcessCanBePerformed::class)
    ->name('orders.items.processes.perform');
