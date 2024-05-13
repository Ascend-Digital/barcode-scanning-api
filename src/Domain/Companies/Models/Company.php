<?php

namespace Domain\Companies\Models;

use Domain\Orders\Models\Order;
use Domain\Processes\Models\Process;
use Domain\Subscriptions\Models\Subscription;
use Domain\Warehouses\Models\Warehouse;
use Domain\Workstations\Models\Workstation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function workstations(): HasMany
    {
        return $this->hasMany(Workstation::class);
    }

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class);
    }

    public function processes()
    {
        return $this->hasMany(Process::class);
    }
}
