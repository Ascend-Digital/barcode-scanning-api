<?php

namespace Domain\Processes\Models;

use Domain\Companies\Models\Company;
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
}