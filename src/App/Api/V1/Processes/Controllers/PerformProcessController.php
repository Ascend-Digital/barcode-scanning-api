<?php

namespace App\Api\V1\Processes\Controllers;

use App\Api\V1\Orders\Resources\OrderItemResource;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Actions\EnsureProcessCanBePerformed;
use Domain\Processes\Actions\PerformProcess;
use Domain\Processes\Models\Process;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PerformProcessController
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        OrderItem $orderItem,
        Process $process,
        EnsureProcessCanBePerformed $ensureProcessCanBePerformed,
        PerformProcess $performProcess): JsonResponse
    {
        $ensureProcessCanBePerformed->execute($orderItem, $process);
        $performProcess->execute($orderItem, $process);

        return (new OrderItemResource($orderItem))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
