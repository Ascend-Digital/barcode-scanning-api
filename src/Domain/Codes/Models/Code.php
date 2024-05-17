<?php

namespace Domain\Codes\Models;

use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'code',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }
}
