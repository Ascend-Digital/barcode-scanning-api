<?php

namespace App\Api\V1\Items\Controllers;

use App\Api\V1\Items\Requests\PickItemRequest;
use App\Api\V1\Orders\Resources\OrderItemResource;
use Domain\Orders\Actions\PickItem;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Warehouses\Models\StorageLocation;
use Exception;

class PickItemController
{
    /**
     * @throws Exception
     */
    public function __invoke(
        PickItemRequest $pickItemRequest,
        PickItem $pickItemAction,
        Order $order,
        StorageLocation $storageLocation,
        Item $item): OrderItemResource
    {
        $quantity = $pickItemRequest->validated('quantity');

        /**
         * @var $orderItem OrderItem
         */
        $orderItem = OrderItem::with('order', 'item')
            ->where('order_id', $order->id)
            ->where('item_id', $item->id)
            ->sole();

        // TODO use DTOs
        $pickItemAction->execute($quantity, $storageLocation, $item);

        return new OrderItemResource($orderItem);
    }
}
