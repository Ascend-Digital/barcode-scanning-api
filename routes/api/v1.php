<?php

use App\Api\V1\Barcodes\Controllers\ScanBarcodeController;
use App\Api\V1\Items\Controllers\PickOrderItemController;
use App\Api\V1\Items\Controllers\PlaceItemController;
use App\Api\V1\Items\Controllers\PlaceOrderItemController;
use App\Api\V1\Processes\Controllers\PerformProcessController;
use Illuminate\Support\Facades\Route;

Route::get('/barcodes/{barcode:barcode}', ScanBarcodeController::class)->name('barcodes.scan');

//TODO Sanctum auth
Route::post('/order-items/{orderItem}/processes/{process}', PerformProcessController::class)->name('order-items.processes');
//Route::post('/orders/{order}/storage-locations/{storageLocation}/items/{item}/pick', PickOrderItemController::class)->name('orders.storage-locations.items.pick');
Route::post('/storage-locations/{storageLocation}/order-items/{orderItem}/pick', PickOrderItemController::class)->name('storage-locations.order-items.pick');
Route::post('/storage-locations/{storageLocation}/order-items/{orderItem}/place', PlaceOrderItemController::class)->name('storage-locations.order-items.place');
Route::post('/storage-locations/{storageLocation}/items/{item}/place', PlaceItemController::class)->name('storage-locations.items.place');
