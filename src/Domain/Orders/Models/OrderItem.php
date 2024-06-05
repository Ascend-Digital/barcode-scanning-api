<?php

namespace Domain\Orders\Models;

use Domain\Processes\Models\Process;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderItem extends Model
{
    protected $casts = ['completed_at' => 'datetime'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function processes(): BelongsToMany
    {
        return $this->belongsToMany(Process::class, 'order_item_process', 'order_item_id')->withPivot('completed_at'); // todo change item_order_id after migration
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
