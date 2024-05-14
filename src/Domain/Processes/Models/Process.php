<?php

namespace Domain\Processes\Models;

use Domain\Companies\Models\Company;
use Domain\Statuses\Models\Status;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Process extends Model
{
    use HasFactory;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function workstations(): BelongsToMany
    {
        return $this->belongsToMany(Workstation::class);
    }

    //    public function status(): BelongsTo
    //    {
    //        return $this->belongsTo(Status::class);
    //    }

    public function fromStatus()
    {
        return $this->belongsTo(Status::class, 'from_status');
    }

    public function toStatus()
    {
        return $this->belongsTo(Status::class, 'to_status');
    }
}
