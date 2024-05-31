<?php

use App\Api\V1\Barcodes\Controllers\ScanBarcodeController;
use App\Http\Middleware\LogScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/barcodes/{barcode:barcode}', ScanBarcodeController::class)->name('barcodes.scan')->middleware(LogScan::class);
Route::get('/storage-locations/{storageLocation}/items/{item}/pick', \App\Api\V1\Barcodes\Controllers\DemoController::class)->name('storage-locations.item.pick');
Route::get('/storage-locations/{storageLocation}/items/{item}/place', \App\Api\V1\Barcodes\Controllers\DemoController::class)->name('storage-locations.item.place');
Route::post('/processes/{process}', \App\Api\V1\Barcodes\Controllers\DemoController::class)->name('processes.perform');
Route::post('/auth/login', \App\Api\V1\Barcodes\Controllers\DemoController::class)->name('login');
