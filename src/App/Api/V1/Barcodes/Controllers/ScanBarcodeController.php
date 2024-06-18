<?php

namespace App\Api\V1\Barcodes\Controllers;

use App\Api\V1\Barcodes\Requests\ScanBarcodeRequest;
use Domain\Barcodes\Models\Barcode;

class ScanBarcodeController
{
    public function __invoke(ScanBarcodeRequest $request, Barcode $barcode)
    {
        /*
        We may want to run a specific scan action
        $barcode->owner->scanAction();
        */

        return $barcode
            ->owner()
            ->with('company')
            ->sole()
            ->toResource($request->validated());
    }
}
