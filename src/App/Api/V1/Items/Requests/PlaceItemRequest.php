<?php

namespace App\Api\V1\Items\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
