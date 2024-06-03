<?php

namespace Domain\Items\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemOrderProcess extends Pivot
{
    protected $casts = [
        'completed_at' => 'datetime'
    ];
}
