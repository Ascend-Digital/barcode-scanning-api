<?php

namespace Domain\Processes\Models;

use App\Shared\Traits\Scannable;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\ProcessFactory;
use Domain\Barcodes\Contracts\ScannableModel;
use Domain\Companies\Models\Company;
use Domain\Orders\Models\OrderItem;
use Domain\Statuses\Models\Status;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $from_status
 * @property int $to_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Company $company
 * @property-read Status $fromStatus
 * @property-read Status $toStatus
 * @property-read Collection<int, Workstation> $workstations
 * @property-read int|null $workstations_count
 *
 * @method static ProcessFactory factory($count = null, $state = [])
 * @method static Builder|Process newModelQuery()
 * @method static Builder|Process newQuery()
 * @method static Builder|Process query()
 * @method static Builder|Process whereCompanyId($value)
 * @method static Builder|Process whereCreatedAt($value)
 * @method static Builder|Process whereFromStatus($value)
 * @method static Builder|Process whereId($value)
 * @method static Builder|Process whereName($value)
 * @method static Builder|Process whereToStatus($value)
 * @method static Builder|Process whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Process extends Model implements ScannableModel
{
    use HasFactory;
    use Scannable;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function workstations(): BelongsToMany
    {
        return $this->belongsToMany(Workstation::class);
    }

    public function prerequisiteProcesses(): BelongsToMany
    {
        return $this->belongsToMany(Process::class, 'prerequisite_process', 'process_id', 'prerequisite_id');
    }

    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class, 'order_item_process', 'process_id', 'order_item_id');
    }

    public function fromStatus()
    {
        return $this->belongsTo(Status::class, 'from_status');
    }

    public function toStatus()
    {
        return $this->belongsTo(Status::class, 'to_status');
    }

    public function getCompanyId(): int
    {
        return $this->company_id;
    }
}
