<?php

namespace Domain\Processes\Actions;

use App\Api\V1\Processes\Resources\ProcessCollection;
use Domain\Orders\Models\OrderItem;
use Illuminate\Support\Collection;
use Throwable;

class PerformProcessAction
{
    /**
     * @throws Throwable
     */
    public function execute($orderItem, $process): void
    {
        $allPrerequisitesForCurrentProcess = $process->withAllPrerequisites();

        $completeOrderItemPrerequisites = $this->getMatchingOrderItemProcesses($orderItem, $allPrerequisitesForCurrentProcess);
        $completeOrderItemPrerequisites->validate($allPrerequisitesForCurrentProcess);
    }

    private function getMatchingOrderItemProcesses(OrderItem $orderItem, Collection $allPrerequisites): ProcessCollection // check if completed?
    {
        return new ProcessCollection($orderItem->processes()
            ->whereIn('order_item_process.process_id', $allPrerequisites->pluck('id'))
            ->get());
    }
}
