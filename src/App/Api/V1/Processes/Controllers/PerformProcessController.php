<?php

namespace App\Api\V1\Processes\Controllers;

use App\Api\V1\Processes\Resources\ProcessResource;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Actions\PerformProcessAction;
use Domain\Processes\Models\Process;
use Exception;
use Illuminate\Validation\ValidationException;

class PerformProcessController
{
    /**
     * @throws Exception
     */
    public function __invoke(Order $order, Item $item, Process $process, PerformProcessAction $performProcessAction)
    {
        $orderItem = OrderItem::where('order_id', $order->id)->first();
        $performProcessAction->execute($orderItem, $process);

        return response()->json('success');
//        return OrderItemResource::make($orderItem);

   }
}
