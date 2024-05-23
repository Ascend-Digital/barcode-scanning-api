<?php

namespace Domain\Warehouses\Models;

use Domain\Companies\Models\Company;
use Domain\Processes\Models\Process;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $warehouse_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Process> $processes
 * @property-read int|null $processes_count
 * @property-read \Domain\Warehouses\Models\Warehouse $warehouse
 *
 * @method static \Database\Factories\WorkstationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Workstation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Workstation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Workstation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Workstation whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workstation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workstation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workstation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workstation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workstation whereWarehouseId($value)
 *
 * @mixin \Eloquent
 */
class Workstation extends Model
{
    use HasFactory;

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
}
