<?php

namespace App\Api\V1\Orders\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use App\Api\V1\Items\Resources\ItemResource;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\ItemCollection;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Illuminate\Http\Request;

class OrderResource extends ScannableResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'Order',
            'company' => new CompanyResource($this->whenLoaded('company')),
            'order_items' =>  OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }

    private function items(): ItemCollection
    {
        return new ItemCollection($this->orderItems->map(function ($orderItem) {
            return $orderItem->item;
        }));
    }
}
