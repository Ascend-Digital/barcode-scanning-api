<?php

namespace Domain\Orders\Models;

use Domain\Processes\Models\Process;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderItem extends Model
{
    use HasFactory;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function processes(): BelongsToMany
    {
        return $this->belongsToMany(Process::class)->using(OrderItemProcess::class)->withPivot('completed_at');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
