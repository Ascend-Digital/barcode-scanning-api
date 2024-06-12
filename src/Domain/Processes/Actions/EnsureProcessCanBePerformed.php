<?php

namespace Domain\Processes\Actions;

use Domain\Orders\Models\OrderItem;
use Domain\Processes\Models\Process;
use Domain\Processes\Models\ProcessCollection;
use Illuminate\Support\Collection;
use Throwable;

class EnsureProcessCanBePerformed
{
    /**
     * @throws Throwable
     */
    public function execute(OrderItem $orderItem, Process $process): void
    {
        $allPrerequisitesForCurrentProcess = $process->retrieveAllPrerequisites();

        $completeOrderItemPrerequisites = $this->getMatchingOrderItemProcesses($orderItem, $allPrerequisitesForCurrentProcess);
        $completeOrderItemPrerequisites->validate($allPrerequisitesForCurrentProcess);
    }

    private function getMatchingOrderItemProcesses(OrderItem $orderItem, Collection $allPrerequisites): ProcessCollection
    {
        return new ProcessCollection($orderItem->processes()
            ->whereIn('order_item_process.process_id', $allPrerequisites->pluck('id'))
            ->get());
    }
}
