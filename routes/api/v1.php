<?php

use App\Api\V1\Barcodes\Controllers\ScanBarcodeController;
use App\Http\Middleware\LogScan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/barcodes/{barcode:barcode}', ScanBarcodeController::class)->name('barcodes.scan')->middleware(LogScan::class);
