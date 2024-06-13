<?php

use App\Exceptions\IncompleteProcessException;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Actions\EnsureProcessCanBePerformed;
use Domain\Processes\Models\Process;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('throws an exception if a an order item process has incomplete prerequisites', function () {
    $prerequisites = Process::factory(5)->create();
    $process = Process::factory()->hasAttached($prerequisites, [], 'prerequisiteProcesses')->create();

    $this->expectException(IncompleteProcessException::class);
    $this->expectExceptionMessage('The following prerequisites are incomplete: '.implode(', ', $prerequisites->pluck('name')->toArray()));

    $orderItem = OrderItem::factory()
        ->for(Order::factory())
        ->for(Item::factory()
            ->hasAttached($process))
        ->create();

    $action = new EnsureProcessCanBePerformed();
    $action->execute($orderItem, $process);
});

it('throws an exception with nested prerequisites if an order item process has incomplete prerequisites', function () {
    $doubleNestedPrerequisites = Process::factory(12)->create();
    $nestedPrerequisites = Process::factory(2)->hasAttached($doubleNestedPrerequisites, [], 'prerequisiteProcesses')->create();
    $topLevelPrerequisite = Process::factory()->hasAttached($nestedPrerequisites, [], 'prerequisiteProcesses')->create();

    $allPrerequisiteNames = [
        ...$doubleNestedPrerequisites->pluck('name')->toArray(),
        ...$nestedPrerequisites->pluck('name')->toArray(),
        $topLevelPrerequisite->name,
    ];

    $this->expectException(IncompleteProcessException::class);
    $this->expectExceptionMessage('The following prerequisites are incomplete: '.implode(', ', $allPrerequisiteNames));

    $process = Process::factory()->hasAttached($topLevelPrerequisite, [], 'prerequisiteProcesses')->create();
    $orderItem = OrderItem::factory()
        ->for(Order::factory())
        ->for(Item::factory()
            ->hasAttached($process))
        ->create();

    $action = new EnsureProcessCanBePerformed();
    $action->execute($orderItem, $process);
});
