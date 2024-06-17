<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Models\Item;
use Domain\Warehouses\Models\StorageLocation;

class UpdateItemQuantity
{
    public function execute(StorageLocation $storageLocation, Item $item, int $addedQuantity, int $currentQuantity): Item
    {
        $newQuantity = $currentQuantity + $addedQuantity;

        $storageLocation->items()->updateExistingPivot($item->id, [
            'quantity' => $newQuantity,
            'last_placed_at' => now(),
            'last_placed_quantity' => $addedQuantity,
        ]);

        return $item;
    }
}
