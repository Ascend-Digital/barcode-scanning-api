<?php

namespace Domain\Warehouses\Models;

use App\Api\V1\Warehouses\Resources\WarehouseResource;
use App\Shared\Traits\Scannable;
use Database\Factories\WarehouseFactory;
use Domain\Barcodes\Contracts\ScannableModel;
use Domain\Barcodes\Models\Barcode;
use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Support\Contracts\ResourcableModel;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Company $company
 * @property-read Collection<int, StorageLocation> $storageLocations
 * @property-read int|null $storage_locations_count
 * @property-read Collection<int, Workstation> $workstations
 * @property-read int|null $workstations_count
 *
 * @method static WarehouseFactory factory($count = null, $state = [])
 * @method static Builder|Warehouse newModelQuery()
 * @method static Builder|Warehouse newQuery()
 * @method static Builder|Warehouse query()
 * @method static Builder|Warehouse whereCompanyId($value)
 * @method static Builder|Warehouse whereCreatedAt($value)
 * @method static Builder|Warehouse whereId($value)
 * @method static Builder|Warehouse whereName($value)
 * @method static Builder|Warehouse whereUpdatedAt($value)
 *
 * @property-read Barcode|null $barcode
 */
class Warehouse extends Model implements ResourcableModel, ScannableModel
{
    use HasFactory;
    use Scannable;

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

    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    public function toResource(array $parameters): JsonResource
    {
        return new WarehouseResource($this, $parameters);
    }
}
