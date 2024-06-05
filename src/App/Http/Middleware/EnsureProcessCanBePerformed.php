<?php

namespace App\Http\Middleware;

use App\Api\V1\Processes\Resources\ProcessCollection;
use Closure;
use Domain\Orders\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class EnsureProcessCanBePerformed
{
    /**
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $process = $request->route('process');
        $item = $request->route('item');
        $order = $request->route('order');

        $allPrerequisites = $process->withAllPrerequisites();

        // get the matching order item
        $orderItem = OrderItem::where('order_id', $order->id)->first();

        // get the order item processes which are also in the prerequisite processes
        $processes = $orderItem->processes()->whereIn('order_item_process.id', $allPrerequisites->pluck('id'))->get();

        $incompleteItemProcesses = new ProcessCollection();
        foreach ($processes as $process) {
            if ($process->pivot->completed_at === null) {
                $incompleteItemProcesses[] = $process;
            }
        }

        $incompleteItemProcesses->validate($allPrerequisites);

        return $next($request);
    }
}
