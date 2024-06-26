<?php

namespace App\Api\V1\Items\Controllers;

use App\Api\V1\Items\Requests\PickItemRequest;
use App\Api\V1\Orders\Resources\OrderItemResource;
use Domain\Orders\Actions\PickItem;
use Domain\Orders\Models\OrderItem;
use Domain\Warehouses\Models\StorageLocation;
use Exception;

class PickOrderItemController
{
    /**
     * @throws Exception
     */
    public function __invoke(
        PickItemRequest $pickItemRequest,
        PickItem $pickItemAction,
        StorageLocation $storageLocation,
        OrderItem $orderItem): OrderItemResource
    {
        $quantity = $pickItemRequest->validated('quantity');

        // TODO use DTOs
        $pickItemAction->execute($quantity, $storageLocation, $orderItem);

        return new OrderItemResource($orderItem);
    }
}
