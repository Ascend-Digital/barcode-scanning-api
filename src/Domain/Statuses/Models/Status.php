<?php

namespace Domain\Statuses\Models;

use Domain\Companies\Models\Company;
use Domain\Orders\Models\Order;
use Domain\Processes\Models\Process;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends Model
{
    use HasFactory;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function process()
    {
        return $this->hasMany(Process::class);
    }

    public function processesWithFromStatus()
    {
        return $this->hasMany(Process::class, 'from_status');
    }

    public function processesWithToStatus()
    {
        return $this->hasMany(Process::class, 'to_status');
    }
}
