<?php

namespace App\Observers;

use App\Exceptions\IncompleteProcessException;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Orders\Models\OrderItemProcess;
use Domain\Processes\Actions\PerformProcessAction;
use Domain\Processes\Models\Process;
use Throwable;

class OrderItemProcessObserver
{
    /**
     * @throws Throwable
     */
    public function creating(OrderItemProcess $orderItemProcess): void
    {
        $process = Process::where('id', $orderItemProcess->process_id)->first();
        $orderItem = OrderItem::where('id', $orderItemProcess->order_item_id)->first();
        $order = Order::where('id', $orderItem->order_id)->first();

        try {
            (new PerformProcessAction())->execute($orderItem, $process);
        } catch (IncompleteProcessException $exception) {
            // display the message to the user
            abort(500, $exception->getMessage());
        }

        $order->status_id = $process->to_status;
        $order->save();
    }

    // TODO e2e test of this
}
