<?php

namespace Domain\Items\Models;

use Domain\Orders\Models\Order;
use Domain\Processes\Models\Process;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{
    public $timestamps = false;
    public $incrementing = true;

    protected $casts = ['completed_at' => 'datetime'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function processes(): BelongsToMany
    {
        return $this->belongsToMany(Process::class, 'item_order_process', 'item_order_id')->withPivot('completed_at'); // todo change item_order_id after migration
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
