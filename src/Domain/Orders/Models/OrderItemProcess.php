<?php

namespace Domain\Orders\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItemProcess extends Pivot
{
    protected $fillable = [
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];
}
