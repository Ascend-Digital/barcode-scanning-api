<?php

namespace Domain\Orders\Policies;

use Domain\Orders\Models\OrderItem;
use Domain\Users\Models\User;

class OrderItemPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, OrderItem $orderItem): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, OrderItem $orderItem): bool
    {
        return false;
    }

    public function delete(User $user, OrderItem $orderItem): bool
    {
        return false;
    }
}
