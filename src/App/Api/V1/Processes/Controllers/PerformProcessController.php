<?php

namespace App\Api\V1\Processes\Controllers;

use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Actions\EnsureProcessCanBePerformed;
use Domain\Processes\Actions\PerformProcess;
use Domain\Processes\Models\Process;
use Illuminate\Http\JsonResponse;
use Throwable;

class PerformProcessController
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        Order $order,
        Item $item,
        Process $process,
        EnsureProcessCanBePerformed $ensureProcessCanBePerformed,
        PerformProcess $performProcess): JsonResponse
    {
        /**
         * @var $orderItem OrderItem
         */
        $orderItem = OrderItem::with('order', 'item')
            ->where('order_id', $order->id)
            ->where('item_id', $item->id)
            ->sole();

        $ensureProcessCanBePerformed->execute($orderItem, $process);
        $performProcess->execute($orderItem, $process, $order);

        return response()->json(['success' => 'true'], 201);
    }
}
