<?php

use Domain\Items\Models\Item;
use Domain\Items\Models\OrderItem;
use Domain\Orders\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('throws a validation exception if a process has incomplete prerequisites', function () {
    $order = Order::factory()->create();
    $item = Item::factory()->create();
    $prerequisite = \Domain\Processes\Models\Process::factory()->create();
    $process = \Domain\Processes\Models\Process::factory()->create();
    $process->prerequisiteProcesses()->sync($prerequisite);
    $orderItem = OrderItem::make();
    $orderItem->order()->associate($order);
    $orderItem->item()->associate($item);
    $orderItem->save();
    $orderItem->processes()->attach($prerequisite);

    $response = $this->postJson(route('orders.items.processes.perform', ['order' => $order, 'item' => $item, 'process' => $process]));

    $response->assertStatus(422);

});

it('has a success response if there are no incomplete prerequisites', function () {
    $order = Order::factory()->create();
    $item = Item::factory()->create();
    $prerequisite = \Domain\Processes\Models\Process::factory()->create();
    $process = \Domain\Processes\Models\Process::factory()->create();
    $process->prerequisiteProcesses()->sync($prerequisite);
    $orderItem = OrderItem::make();
    $orderItem->order()->associate($order);
    $orderItem->item()->associate($item);
    $orderItem->save();

    $orderItem->processes()->attach($process, ['completed_at' => now()]); // for no incomplete processes

    $response = $this->postJson(route('orders.items.processes.perform', ['order' => $order, 'item' => $item, 'process' => $process]));

    $response->assertStatus(200);

});
