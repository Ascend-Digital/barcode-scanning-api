<?php

namespace Domain\Orders\Policies;

use Domain\Orders\Models\Order;
use Domain\Users\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Order $order): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Order $order): bool
    {
        //
    }

    public function delete(User $user, Order $order): bool
    {
        //
    }

    public function restore(User $user, Order $order): bool
    {
        //
    }

    public function forceDelete(User $user, Order $order): bool
    {
        //
    }
}
