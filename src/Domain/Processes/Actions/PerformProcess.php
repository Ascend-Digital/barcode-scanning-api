<?php

namespace Domain\Processes\Actions;

class PerformProcess
{
    public function execute($orderItem, $process, $order)
    {
        $orderItem->processes()->attach($process, ['completed_at' => now()]);

        $order->status()->associate($process->to_status);



    }

}
