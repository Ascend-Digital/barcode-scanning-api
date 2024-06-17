<?php

namespace App\Api\V1\Items\Controllers;

use App\Api\V1\Items\Requests\PickItemRequest;
use Domain\Orders\Actions\PickItem;
use Domain\Orders\Models\Item;
use Domain\Warehouses\Models\StorageLocation;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PickItemController
{
    /**
     * @throws Exception
     */
    public function __invoke(PickItemRequest $pickItemRequest, PickItem $pickItemAction, StorageLocation $storageLocation, Item $item): JsonResponse
    {
        $quantity = $pickItemRequest->validated('quantity');

        // TODO use DTOs
        $pickItemAction->execute($quantity, $storageLocation, $item);

        // TODO we may want a resource here
        return response()->json(['success' => 'true'], ResponseAlias::HTTP_OK);
    }
}
