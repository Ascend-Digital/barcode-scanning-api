<?php

use Domain\Orders\Models\Order;
use Domain\Orders\Policies\OrderPolicy;
use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('is set up correctly for admin and non-admin users', function (User $user, string $action, bool $expectedResult) {
    $order = Order::factory()->create();
    Gate::policy(Order::class, OrderPolicy::class);
    $this->assertEquals($expectedResult, Gate::forUser($user)->allows($action, $order));
})->with([
    [fn () => User::factory()->create(['email' => 'test@ascend.agency']), 'action' => 'view-any', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'test@ascend.agency']), 'action' => 'view', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'test2@ascend.agency']), 'action' => 'create', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'test3@ascend.agency']), 'action' => 'update', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'dev@ascend.agency']), 'action' => 'delete', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'not-ascend-email@example.com']), 'action' => 'view-any', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'not-ascend-email@example.com']), 'action' => 'view', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'not-ascend-email@example.com']), 'action' => 'create', 'expectedResult' => false],
    [fn () => User::factory()->create(['email' => 'not-ascend-email@example.com']), 'action' => 'update', 'expectedResult' => false],
    [fn () => User::factory()->create(['email' => 'not-ascend-email@example.com']), 'action' => 'delete', 'expectedResult' => false],
]);
