<?php

namespace Domain\Companies\Models;

use Domain\Items\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Processes\Models\Process;
use Domain\Statuses\Models\Status;
use Domain\Subscriptions\Models\Subscription;
use Domain\Users\Models\StaffMember;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function processes(): HasMany
    {
        return $this->hasMany(Process::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class);
    }

    public function storageLocations(): HasMany
    {
        return $this->hasMany(StorageLocation::class);
    }

    public function staffMembers(): HasMany
    {
        return $this->hasMany(StaffMember::class);
    }
}
