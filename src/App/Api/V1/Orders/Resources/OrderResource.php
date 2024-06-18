<?php

namespace App\Api\V1\Orders\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use App\Api\V1\Items\Resources\ItemResource;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\ItemCollection;
use Illuminate\Http\Request;

class OrderResource extends ScannableResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'Order',
            'company' => new CompanyResource($this->whenLoaded('company')),
            'items' => $this->whenLoaded('orderItems', function () {
                return ItemResource::collection($this->items()->map(function (Item $item) {
                    // TODO check whether n+1 here
                    return new ItemResource($item, $this->parameters);
                }));
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
