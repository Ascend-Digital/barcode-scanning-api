<?php

use Carbon\Carbon;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Models\Process;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('performs a process on the correct order item', function () {
    \Illuminate\Support\Carbon::setTestNow(Carbon::parse('2024-06-12 12:00:00'));
    $order = Order::factory()->create();
    $item = Item::factory()->create();

    $orderItem = OrderItem::factory([
        'order_id' => $order->id,
        'item_id' => $item->id,
    ])->create();

    $process = Process::factory()->create();

    $this
        ->postJson(route('api.v1.orders.items.processes', ['order' => $order, 'item' => $item, 'process' => $process]))
        ->assertCreated();

    $this->assertDatabaseHas('order_item_process', ['order_item_id' => $orderItem->id, 'process_id' => $process->id, 'completed_at' => '2024-06-12 12:00:00']);
});

it('returns incomplete prerequisites if any are incomplete', function () {
    $prerequisite = Process::factory()->create();
    $process = Process::factory()->hasAttached($prerequisite, [], 'prerequisiteProcesses')->create();

    $order = Order::factory()->create();
    $item = Item::factory()->create();

    OrderItem::factory([
        'order_id' => $order->id,
        'item_id' => $item->id,
    ])->create();

    $this
        ->postJson(route('api.v1.orders.items.processes', ['order' => $order, 'item' => $item, 'process' => $process]))
        ->assertUnprocessable()
        ->assertJsonFragment([
            'message' => "The following prerequisites are incomplete: {$prerequisite->name}",
        ]);
});
