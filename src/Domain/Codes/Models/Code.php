<?php

namespace Domain\Codes\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $company_id
 * @property string $owner_type
 * @property int $owner_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Company $company
 * @property-read Model|Eloquent $owner
 *
 * @method static \Database\Factories\CodeFactory factory($count = null, $state = [])
 * @method static Builder|Code newModelQuery()
 * @method static Builder|Code newQuery()
 * @method static Builder|Code query()
 * @method static Builder|Code whereCompanyId($value)
 * @method static Builder|Code whereCreatedAt($value)
 * @method static Builder|Code whereId($value)
 * @method static Builder|Code whereOwnerId($value)
 * @method static Builder|Code whereOwnerType($value)
 * @method static Builder|Code whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
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
