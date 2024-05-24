<?php

namespace Domain\Items\Models;

use App\Api\V1\Items\Resources\ItemResource;
use App\Shared\Traits\Scannable;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\ItemFactory;
use Domain\Companies\Models\Company;
use Domain\Warehouses\Models\StorageLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Support\Contracts\ResourcableModel;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property $barcode
 * @property $availableActions
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
 * @method availableActions()
 * @method mixed __get($name)
 * @method void __set($name, $value)
 * @method bool __isset($name)
 * @method void __unset($name)
 *
 * @mixin Eloquent
 */
class Item extends Model implements ResourcableModel
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

    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    public function storageLocations(): BelongsToMany
    {
        return $this->belongsToMany(StorageLocation::class);
    }

    public function toResource(): ItemResource
    {
        return new ItemResource($this);
    }

    public function scanAction(): void
    {
        //
    }
}
