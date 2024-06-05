<?php

use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('is set up correctly for admin and non-admin users', function (User $user, string $action, bool $expectedResult) {
    $this->assertEquals($expectedResult, Gate::forUser($user)->allows($action));
})->with([
    [fn () => User::factory()->create(['email' => 'test@ascend.agency']), 'action' => 'view-order', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'test2@ascend.agency']), 'action' => 'create-order', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'test3@ascend.agency']), 'action' => 'update-order', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'dev@ascend.agency']), 'action' => 'delete-order', 'expectedResult' => true],
    [fn () => User::factory()->create(['email' => 'not-ascend-email@example.com']), 'action' => 'view-order', 'expectedResult' => false],
    [fn () => User::factory()->create(['email' => 'not-ascend-email@example.com']), 'action' => 'create-order', 'expectedResult' => false],
    [fn () => User::factory()->create(['email' => 'not-ascend-email@example.com']), 'action' => 'update-order', 'expectedResult' => false],
    [fn () => User::factory()->create(['email' => 'not-ascend-email@example.com']), 'action' => 'delete-order', 'expectedResult' => false],
]);
