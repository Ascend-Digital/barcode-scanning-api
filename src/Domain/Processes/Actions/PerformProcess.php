<?php

namespace Domain\Processes\Actions;

use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Models\Process;

class PerformProcess
{
    public function execute(OrderItem $orderItem, Process $process, Order $order): void
    {
        $orderItem->processes()->attach($process, ['completed_at' => now()]);

        $order->status()->associate($process->to_status);
    }
}
