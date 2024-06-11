<?php

use App\Api\V1\Barcodes\Controllers\ScanBarcodeController;
use Illuminate\Support\Facades\Route;

Route::get('/barcodes/{barcode:barcode}', ScanBarcodeController::class)->name('barcodes.scan');
