<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Models\Item;
use Domain\Warehouses\Models\StorageLocation;

class AddItemToStorageLocation
{
    public function execute(int $quantity, StorageLocation $storageLocation, Item $item): Item
    {
        // TODO explore whether this should be in a transaction
        $storageLocation->items()->attach(
            $item->id, [
                'quantity' => $quantity,
                'last_placed_at' => now(),
                'last_placed_quantity' => $quantity,
            ]
        );

        return $item;
    }
}
