<?php

namespace Domain\Warehouses\Models;

use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Domain\Warehouses\Models\StorageLocation> $storageLocations
 * @property-read int|null $storage_locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Domain\Warehouses\Models\Workstation> $workstations
 * @property-read int|null $workstations_count
 *
 * @method static \Database\Factories\WarehouseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Warehouse whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Warehouse extends Model
{
    use HasFactory;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function storageLocations(): HasMany
    {
        return $this->hasMany(StorageLocation::class);
    }

    public function workstations()
    {
        return $this->hasMany(Workstation::class);
    }
}
