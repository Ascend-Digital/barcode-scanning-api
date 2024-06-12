<?php

namespace App\Api\V1\Orders\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use App\Api\V1\Items\Resources\ItemResource;
use Domain\Orders\Models\ItemCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'Order',
            'company' => new CompanyResource($this->whenLoaded('company')),
            'items' => $this->whenLoaded('orderItems', function () {
                return ItemResource::collection($this->items());
            }),
            'actions' => ScannableActionResource::collection($this->actions()),
        ];
    }

    private function items(): ItemCollection
    {
        return new ItemCollection($this->orderItems->map(function ($orderItem) {
            return $orderItem->item;
        }));
    }
}
