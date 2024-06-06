<?php

namespace Domain\Orders\Policies;

use Domain\Orders\Models\OrderItem;
use Domain\Users\Models\User;

class OrderItemPolicy
{
    public function view(User $user, OrderItem $orderItem): bool
    {
        return true;
    }

    public function update(User $user, OrderItem $orderItem): bool
    {
        return false;
    }
}
