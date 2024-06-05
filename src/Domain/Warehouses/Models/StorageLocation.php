<?php

namespace Domain\Warehouses\Models;

use App\Shared\Traits\Scannable;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\StorageLocationFactory;
use Domain\Barcodes\Contracts\ScannableModel;
use Domain\Companies\Models\Company;
use Domain\Orders\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $warehouse_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Company $company
 * @property-read \Domain\Warehouses\Models\Warehouse $warehouse
 *
 * @method static StorageLocationFactory factory($count = null, $state = [])
 * @method static Builder|StorageLocation newModelQuery()
 * @method static Builder|StorageLocation newQuery()
 * @method static Builder|StorageLocation query()
 * @method static Builder|StorageLocation whereCompanyId($value)
 * @method static Builder|StorageLocation whereCreatedAt($value)
 * @method static Builder|StorageLocation whereId($value)
 * @method static Builder|StorageLocation whereName($value)
 * @method static Builder|StorageLocation whereUpdatedAt($value)
 * @method static Builder|StorageLocation whereWarehouseId($value)
 *
 * @mixin Eloquent
 */
class StorageLocation extends Model implements ScannableModel
{
    use HasFactory;
    use Scannable;

    protected $fillable = [
        'name',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }

    public function getCompanyId(): int
    {
        return $this->company_id;
    }
}
