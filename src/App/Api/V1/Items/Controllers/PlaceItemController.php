<?php

namespace App\Api\V1\Items\Controllers;

use App\Api\V1\Items\Requests\PlaceItemRequest;
use Domain\Orders\Actions\AddItemToStorageLocation;
use Domain\Orders\Actions\UpdateItemQuantity;
use Domain\Orders\Models\Item;
use Domain\Warehouses\Models\StorageLocation;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PlaceItemController
{
    public function __invoke(
        PlaceItemRequest $placeItemRequest,
        AddItemToStorageLocation $addItemToStorageLocation,
        UpdateItemQuantity $updateItemQuantity,
        StorageLocation $storageLocation,
        Item $item): JsonResponse
    {
        $quantity = $placeItemRequest->validated('quantity');
        $itemInStorage = $storageLocation->items()->find($item->id);

        // TODO use DTOs
        if (! $itemInStorage) {
            try {
                $addItemToStorageLocation->execute($quantity, $storageLocation, $item);
            } catch (\Exception $exception) {
                return new JsonResponse(['error' => $exception->getMessage()], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            $updateItemQuantity->execute($storageLocation, $item, $quantity, $itemInStorage->pivot->quantity);
        }

        // TODO we may want a resource here
        return response()->json(['success' => 'true'], ResponseAlias::HTTP_OK);

    }
}
