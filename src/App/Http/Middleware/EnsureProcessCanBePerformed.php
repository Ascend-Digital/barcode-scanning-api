<?php

namespace App\Http\Middleware;

use App\Api\V1\Processes\Resources\ProcessCollection;
use Closure;
use Domain\Orders\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EnsureProcessCanBePerformed
{
    /**
     * @throws ValidationException|Throwable
     */
    public function handle(Request $request, Closure $next): Response
    {
        $process = $request->route('process');
        $order = $request->route('order');
        $item = $request->route('item');

        $allPrerequisitesForCurrentProcess = $process->withAllPrerequisites();

        $orderItem = $this->getOrderItem($order, $item);
        $orderItemPrerequisites = $this->getMatchingOrderItemProcesses($orderItem, $allPrerequisitesForCurrentProcess);

        /**
         * @var ProcessCollection $incompleteItemProcesses
         */
        $incompleteItemProcesses = $this->getIncompleteItemProcesses($orderItemPrerequisites);

        $incompleteItemProcesses->validate($allPrerequisitesForCurrentProcess);

        return $next($request);
    }

    private function getOrderItem($order, $item): OrderItem
    {
        return OrderItem::where('order_id', $order->id)
            ->where('item_id', $item->id)
            ->firstOrFail();
    }

    private function getMatchingOrderItemProcesses(OrderItem $orderItem, Collection $allPrerequisites): Collection
    {
        return $orderItem->processes()
            ->whereIn('order_item_process.id', $allPrerequisites->pluck('id'))
            ->get();
    }

    private function getIncompleteItemProcesses(Collection $processes): Collection
    {
        return $processes->where('pivot.completed_at', null);
    }
}
