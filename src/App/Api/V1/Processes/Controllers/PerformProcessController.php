<?php

namespace App\Api\V1\Processes\Controllers;

use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Actions\PerformProcessAction;
use Domain\Processes\Models\Process;
use Illuminate\Http\JsonResponse;
use Throwable;

class PerformProcessController
{
    /**
     * @throws Throwable
     */
    public function __invoke(Order $order, Item $item, Process $process, PerformProcessAction $performProcessAction): JsonResponse
    {
        $orderItem = OrderItem::with('order', 'item')
            ->where('order_id', $order->id)
            ->where('item_id', $item->id)
            ->sole();

        $performProcessAction->execute($orderItem, $process);

        $orderItem->processes()->attach($orderItem, ['completed_at' => now()]);
        $order->status()->associate($process->to_status);

        return response()->json(['message' => 'success'], 201);
    }
}
