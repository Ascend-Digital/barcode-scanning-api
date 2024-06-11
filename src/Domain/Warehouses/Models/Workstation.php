<?php

namespace Domain\Warehouses\Models;

use App\Api\V1\Warehouses\Resources\WorkstationResource;
use App\Shared\Traits\Scannable;
use Database\Factories\WorkstationFactory;
use Domain\Barcodes\Contracts\ScannableModel;
use Domain\Companies\Models\Company;
use Domain\Processes\Models\Process;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Support\Contracts\ResourcableModel;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $warehouse_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Company $company
 * @property-read Collection<int, Process> $processes
 * @property-read int|null $processes_count
 * @property-read Warehouse $warehouse
 *
 * @method static WorkstationFactory factory($count = null, $state = [])
 * @method static Builder|Workstation newModelQuery()
 * @method static Builder|Workstation newQuery()
 * @method static Builder|Workstation query()
 * @method static Builder|Workstation whereCompanyId($value)
 * @method static Builder|Workstation whereCreatedAt($value)
 * @method static Builder|Workstation whereId($value)
 * @method static Builder|Workstation whereName($value)
 * @method static Builder|Workstation whereUpdatedAt($value)
 * @method static Builder|Workstation whereWarehouseId($value)
 *
 * @property-read \Domain\Barcodes\Models\Barcode|null $barcode
 */
class Workstation extends Model implements ResourcableModel, ScannableModel
{
    use HasFactory;
    use Scannable;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function processes(): BelongsToMany
    {
        return $this->belongsToMany(Process::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    public function toResource(): JsonResource
    {
        return new WorkstationResource($this);
    }
}
