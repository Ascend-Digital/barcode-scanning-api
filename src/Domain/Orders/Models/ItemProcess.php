<?php

namespace Domain\Items\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemProcess extends Pivot
{
    protected $casts = ['completed_at' => 'datetime'];
}
