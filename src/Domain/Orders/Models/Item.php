<?php

namespace Domain\Orders\Models;

use App\Api\V1\Items\Resources\ItemResource;
use App\Shared\Traits\Scannable;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\ItemFactory;
use Domain\Barcodes\Contracts\ScannableModel;
use Domain\Companies\Models\Company;
use Domain\Processes\Models\Process;
use Domain\Warehouses\Models\StorageLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Support\Contracts\ResourcableModel;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property $barcode
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Company $company
 *
 * @method static ItemFactory factory($count = null, $state = [])
 * @method static Builder|Item newModelQuery()
 * @method static Builder|Item newQuery()
 * @method static Builder|Item query()
 * @method static Builder|Item whereCompanyId($value)
 * @method static Builder|Item whereCreatedAt($value)
 * @method static Builder|Item whereId($value)
 * @method static Builder|Item whereName($value)
 * @method static Builder|Item whereUpdatedAt($value)
 * @method mixed __get($name)
 * @method void __set($name, $value)
 * @method bool __isset($name)
 * @method void __unset($name)
 *
 * @mixin Eloquent
 *
 * @property-read Collection<int, StorageLocation> $storageLocations
 * @property-read int|null $storage_locations_count
 */
class Item extends Model implements ResourcableModel, ScannableModel
{
    use HasFactory;
    use Scannable;

    protected $with = ['storageLocations'];

    protected $fillable = [
        'name',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function storageLocations(): BelongsToMany
    {
        // TODO May be worth promoting item_storage_location pivot model to a standard model
        // TODO Some of these pivot fields may be removed when logging is added
        return $this->belongsToMany(StorageLocation::class)->withPivot(
            'last_picked_at', 'last_placed_at', 'last_picked_quantity', 'last_placed_quantity', 'quantity'
        );
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function processes(): BelongsToMany
    {
        return $this->belongsToMany(Process::class);
    }

    public function storageLocationRestrictions(): BelongsToMany
    {
        return $this->belongsToMany(StorageLocation::class, 'item_storage_location_restrictions', 'item_id', 'storage_location_id');
    }

    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    public function toResource(): ItemResource
    {
        return new ItemResource($this);
    }

    public function canBePlacedInStorageLocation($storageLocation): bool
    {
        return ! $this->whereRelation('storageLocationRestrictions', 'storage_location_id', $storageLocation->id)->exists();
    }
}
