<?php

namespace App\Api\V1\Barcodes\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScanBarcodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'item_id' => ['sometimes', 'integer', 'exists:items,id'],
            'order_id' => ['sometimes', 'integer', 'exists:orders,id'],
            'order_item_id' => ['sometimes', 'integer', 'exists:order_items,id'],
            'storage_location_id' => ['sometimes', 'integer', 'exists:storage_locations,id'],
        ];
    }
}
