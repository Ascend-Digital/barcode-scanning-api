<?php

namespace App\Observers;

use App\Exceptions\IncompleteProcessException;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Orders\Models\OrderItemProcess;
use Domain\Processes\Actions\EnsureProcessCanBePerformed;
use Domain\Processes\Models\Process;
use Throwable;

class OrderItemProcessObserver
{
    /**
     * @throws Throwable
     */
    public function creating(OrderItemProcess $orderItemProcess): void
    {
        $process = Process::find($orderItemProcess->process_id);
        $orderItem = OrderItem::find($orderItemProcess->order_item_id);

        try {
            (new EnsureProcessCanBePerformed())->execute($orderItem, $process);
        } catch (IncompleteProcessException $exception) {
            abort(500, $exception->getMessage());
        }

        $order = Order::find($orderItem->order_id);
//        dd($order->status, $process->to_status);
        $order->status()->associate($process->to_status);
        $order->save();
    }
}
