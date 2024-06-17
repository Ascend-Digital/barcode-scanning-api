<?php

use App\Api\V1\Barcodes\Controllers\ScanBarcodeController;
use App\Api\V1\Items\Controllers\PickItemController;
use App\Api\V1\Items\Controllers\PlaceItemController;
use App\Api\V1\Processes\Controllers\PerformProcessController;
use Illuminate\Support\Facades\Route;

Route::get('/barcodes/{barcode:barcode}', ScanBarcodeController::class)->name('barcodes.scan');

//TODO Sanctum auth
Route::post('/orders/{order}/items/{item}/processes/{process}', PerformProcessController::class)->name('orders.items.processes');
Route::post('/storage-locations/{storageLocation}/items/{item}/pick', PickItemController::class)->name('storage-locations.items.pick');
Route::post('/storage-locations/{storageLocation}/items/{item}/place', PlaceItemController::class)->name('storage-locations.items.place');
