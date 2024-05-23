<?php

namespace Domain\Warehouses\Models;

use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $warehouse_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company $company
 * @property-read \Domain\Warehouses\Models\Warehouse $warehouse
 *
 * @method static \Database\Factories\StorageLocationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|StorageLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageLocation whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageLocation whereWarehouseId($value)
 *
 * @mixin \Eloquent
 */
class StorageLocation extends Model
{
    use HasFactory;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
