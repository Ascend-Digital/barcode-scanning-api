<?php

namespace App\Http\Middleware;

use App\Api\V1\Processes\Resources\ProcessCollection;
use App\Api\V1\Processes\Resources\ProcessResource;
use Closure;
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
//        dd($process, $item, $order, $allPrerequisites);

        // get the matching order item
        $orderItem = $order->items()->where('item_id', $item->id)->first();

        // get the order item processes which are also in the prerequisite processes
        $processes = $orderItem->processes()->whereIn('id', $allPrerequisites->pluck('id'))->get();

//        $processes = $orderItem->pivot->processes()->whereIn('process_id', $allPrerequisites->pluck('id'))->get();
//        dd($processes[0]->pivot->completed_at);
//        dd($allPrerequisites, $processes->pivot->completed_at);
        $incompleteItemProcesses = new ProcessCollection();
        foreach ($processes as $process) {
            if ($process->pivot->completed_at === null) {
                $incompleteItemProcesses[] = $process;
            }
        }
//        dd($incompleteItemProcesses);

//        $incompleteItemProcesses =  $orderItem->processes()->where('completed_at', null)->get();
//        dd($incompleteItemProcesses);

        $incompleteItemProcesses->validate($allPrerequisites);

        return $next($request);
    }
}
