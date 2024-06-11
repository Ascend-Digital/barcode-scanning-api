<?php

namespace Domain\Barcodes\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\BarcodeFactory;
use Domain\Codes\Contracts\ScannableModel;
use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property int $company_id
 * @property string $owner_type
 * @property int $owner_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Company $company
 * @property-read ScannableModel $owner
 * @method static BarcodeFactory factory($count = null, $state = [])
 * @method static Builder|Barcode newModelQuery()
 * @method static Builder|Barcode newQuery()
 * @method static Builder|Barcode query()
 * @method static Builder|Barcode whereCompanyId($value)
 * @method static Builder|Barcode whereCreatedAt($value)
 * @method static Builder|Barcode whereId($value)
 * @method static Builder|Barcode whereOwnerId($value)
 * @method static Builder|Barcode whereOwnerType($value)
 * @method static Builder|Barcode whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $barcode
 * @method static Builder|Barcode whereBarcode($value)
 * @mixin \Eloquent
 */
class Barcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
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
