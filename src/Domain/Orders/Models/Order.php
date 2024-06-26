<?php

namespace Domain\Orders\Models;

use App\Api\V1\Orders\Resources\OrderResource;
use App\Shared\Traits\Scannable;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\OrderFactory;
use Domain\Barcodes\Contracts\ScannableModel;
use Domain\Barcodes\Models\Barcode;
use Domain\Companies\Models\Company;
use Domain\Statuses\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Support\Contracts\ResourcableModel;

/**
 * @property int $id
 * @property int $company_id
 * @property int $status_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Company $company
 * @property-read Status $status
 *
 * @method static OrderFactory factory($count = null, $state = [])
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereCompanyId($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereStatusId($value)
 * @method static Builder|Order whereUpdatedAt($value)
 *
 * @mixin Eloquent
 *
 * @property-read Barcode|null $barcode
 */
class Order extends Model implements ResourcableModel, ScannableModel
{
    use HasFactory;
    use Scannable;

    protected $with = ['orderItems'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    public function toResource(array $parameters): OrderResource
    {
        $this->loadMissing('orderItems.item.storageLocations');

        return new OrderResource($this, $parameters);
    }
}
