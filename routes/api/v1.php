<?php

use App\Api\V1\Barcodes\Controllers\ScanBarcodeController;
use App\Api\V1\Processes\Controllers\PerformProcessController;
use Illuminate\Support\Facades\Route;

Route::get('/barcodes/{barcode:barcode}', ScanBarcodeController::class)->name('barcodes.scan');

//TODO Sanctum auth
Route::post('/orders/{order}/items/{item}/processes/{process}', PerformProcessController::class)->name('orders.items.processes');
