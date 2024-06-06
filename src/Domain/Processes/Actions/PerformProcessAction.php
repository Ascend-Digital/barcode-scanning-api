<?php

namespace Domain\Processes\Actions;

use Domain\Orders\Models\OrderItem;
use Domain\Processes\Models\Process;
use Exception;
use Illuminate\Validation\ValidationException;

class PerformProcessAction
{
    /**
     * @throws Exception
     */
    public function execute(OrderItem $orderItem, Process $process) // TODO use a DTO
    {
        $orderItem->processes()->updateExistingPivot($process->id, ['completed_at' => now()]);

        return $orderItem;

    }
}
