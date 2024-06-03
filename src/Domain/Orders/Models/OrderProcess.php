<?php

namespace Domain\Orders\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProcess extends Pivot
{
    protected $casts = ['completed_at' => 'datetime'];
}
