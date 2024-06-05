<?php

namespace Domain\Orders\Policies;

use Domain\Orders\Models\OrderItem;
use Domain\Users\Models\User;

class OrderItemPolicy
{
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, OrderItem $orderItem): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, OrderItem $orderItem): bool
    {
        //
    }

    public function delete(User $user, OrderItem $orderItem): bool
    {
        //
    }

    public function restore(User $user, OrderItem $orderItem): bool
    {
        //
    }

    public function forceDelete(User $user, OrderItem $orderItem): bool
    {
        //
    }
}
