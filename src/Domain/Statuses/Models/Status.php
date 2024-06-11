<?php

namespace Domain\Statuses\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\StatusFactory;
use Domain\Companies\Models\Company;
use Domain\Orders\Models\Order;
use Domain\Processes\Models\Process;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Company $company
 * @property-read Collection<int, Order> $orders
 * @property-read int|null $orders_count
 * @property-read Collection<int, Process> $process
 * @property-read int|null $process_count
 * @property-read Collection<int, Process> $processesWithFromStatus
 * @property-read int|null $processes_with_from_status_count
 * @property-read Collection<int, Process> $processesWithToStatus
 * @property-read int|null $processes_with_to_status_count
 *
 * @method static StatusFactory factory($count = null, $state = [])
 * @method static Builder|Status newModelQuery()
 * @method static Builder|Status newQuery()
 * @method static Builder|Status query()
 * @method static Builder|Status whereCompanyId($value)
 * @method static Builder|Status whereCreatedAt($value)
 * @method static Builder|Status whereId($value)
 * @method static Builder|Status whereName($value)
 * @method static Builder|Status whereUpdatedAt($value)
 *
 * @mixin Eloquent
 * @mixin \Eloquent
 */
class Status extends Model
{
    use HasFactory;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function process()
    {
        return $this->hasMany(Process::class);
    }

    public function processesWithFromStatus()
    {
        return $this->hasMany(Process::class, 'from_status');
    }

    public function processesWithToStatus()
    {
        return $this->hasMany(Process::class, 'to_status');
    }
}
