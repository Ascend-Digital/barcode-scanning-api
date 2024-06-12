<?php

use App\Exceptions\IncompleteProcessException;
use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Actions\PerformProcessAction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('throws an exception if a an order item process has incomplete prerequisites', function () {
    $prerequisites = \Domain\Processes\Models\Process::factory(5)->create();
    $process = \Domain\Processes\Models\Process::factory()->hasAttached($prerequisites, [], 'prerequisiteProcesses')->create();

    $this->expectException(IncompleteProcessException::class);
    $this->expectExceptionMessage('The following prerequisites are incomplete: '.implode(', ', $prerequisites->pluck('name')->toArray()));

    $orderItem = OrderItem::factory()
        ->for(Order::factory())
        ->for(Item::factory()
            ->hasAttached($process))
        ->create();

    $action = new PerformProcessAction();
    $action->execute($orderItem, $process);
});

it('throws an exception with nested prerequisites if an order item process has incomplete prerequisites', function () {
    $doubleNestedPrerequisites = \Domain\Processes\Models\Process::factory(12)->create();
    $nestedPrerequisites = \Domain\Processes\Models\Process::factory(2)->hasAttached($doubleNestedPrerequisites, [], 'prerequisiteProcesses')->create();
    $topLevelPrerequisite = \Domain\Processes\Models\Process::factory()->hasAttached($nestedPrerequisites, [], 'prerequisiteProcesses')->create();

    $allPrerequisiteNames = [
        ...$doubleNestedPrerequisites->pluck('name')->toArray(),
        ...$nestedPrerequisites->pluck('name')->toArray(),
        $topLevelPrerequisite->name,
    ];

    $this->expectException(IncompleteProcessException::class);
    $this->expectExceptionMessage('The following prerequisites are incomplete: '.implode(', ', $allPrerequisiteNames));

    $process = \Domain\Processes\Models\Process::factory()->hasAttached($topLevelPrerequisite, [], 'prerequisiteProcesses')->create();
    $orderItem = OrderItem::factory()
        ->for(Order::factory())
        ->for(Item::factory()
            ->hasAttached($process))
        ->create();

    $action = new PerformProcessAction();
    $action->execute($orderItem, $process);
});
