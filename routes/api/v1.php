<?php

use App\Api\V1\Barcodes\Controllers\ScanBarcodeController;
use App\Api\V1\Items\Controllers\PickItemController;
use App\Api\V1\Items\Controllers\PlaceItemController;
use App\Api\V1\Processes\Controllers\PerformProcessController;
use Illuminate\Support\Facades\Route;

Route::get('/barcodes/{barcode:barcode}', ScanBarcodeController::class)->name('barcodes.scan');

//TODO Sanctum auth
Route::post('/order-items/{orderItem}/processes/{process}', PerformProcessController::class)->name('order-items.processes');
Route::post('/orders/{order}/storage-locations/{storageLocation}/items/{item}/pick', PickItemController::class)->name('orders.storage-locations.items.pick');
Route::post('/orders/{order}/storage-locations/{storageLocation}/items/{item}/place', PlaceItemController::class)->name('orders.storage-locations.items.place');
