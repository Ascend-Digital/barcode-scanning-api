<?php

namespace Domain\Subscriptions\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\SubscriptionFactory;
use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Company> $companies
 * @property-read int|null $companies_count
 *
 * @method static SubscriptionFactory factory($count = null, $state = [])
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static Builder|Subscription query()
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription whereName($value)
 * @method static Builder|Subscription whereUpdatedAt($value)
 *
 * @mixin Eloquent
 * @mixin \Eloquent
 */
class Subscription extends Model
{
    use HasFactory;

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
