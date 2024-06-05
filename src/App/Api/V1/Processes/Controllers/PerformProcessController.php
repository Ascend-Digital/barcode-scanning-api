<?php

namespace App\Api\V1\Processes\Controllers;

use App\Api\V1\Processes\Resources\ProcessResource;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Actions\CheckProcessPrequisitesAction;
use Domain\Processes\Models\Process;
use Exception;
use Illuminate\Validation\ValidationException;

class PerformProcessController
{
    /**
     * @throws Exception
     */
    public function __invoke(Order $order, Item $item, Process $process, CheckProcessPrequisitesAction $checkProcessPrequisitesAction) //todo can I use a form request? or a custom validator or middleware
    {
        // perform the process with an action
        $orderItem = OrderItem::where('order_id', $order->id)->first();
        $orderItemProcess = $orderItem->processes()->where('process_id', $process->id)->first();

        $orderItemProcess->pivot->completed_at = now();
        $orderItemProcess->save();

        //        try {
        //            $checkProcessPrequisitesAction->execute($process);
        //        } catch (ValidationException $exception) {
        //            dd($exception);
        //
        //            //            $incompleteProcesses = Process::whereIn('id', $exception->getMessage());
        //            //            dd($incompleteProcesses);
        //            //            return (new ProcessResource(Process::find(1)))->response()->setStatusCode(400);
        //            return response()->json(['code' => ['PREREQUISITES_OUTSTANDING'], 'success' => false, 'message' => $exception->getMessage()], 400);
        //        }

        return response()->json(['success' => true]);
    }
}
