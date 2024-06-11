<?php

namespace Domain\Orders\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemOrderProcess extends Pivot
{
    protected $casts = [
        'completed_at' => 'datetime',
    ];
}
