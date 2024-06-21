<?php

use App\Api\V1\Barcodes\Requests\ScanBarcodeRequest;
use JMac\Testing\Traits\AdditionalAssertions;

uses(AdditionalAssertions::class);

it('has rules set up correctly', function () {
    $request = new ScanBarcodeRequest();

    $this->assertValidationRules([
        'item_id' => ['sometimes', 'integer', 'exists:items,id'],
        'order_id' => ['sometimes', 'integer', 'exists:orders,id'],
        'order_item_id' => ['sometimes', 'integer', 'exists:order_items,id'],
        'storage_location_id' => ['sometimes', 'integer', 'exists:storage_locations,id'],
    ], $request->rules());
});
