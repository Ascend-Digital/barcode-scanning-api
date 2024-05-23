<?php

namespace Domain\Users\Models;

use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Company $company
 * @property-read \Domain\Users\Models\User $user
 *
 * @method static \Database\Factories\StaffMemberFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|StaffMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffMember whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffMember whereUserId($value)
 *
 * @mixin \Eloquent
 */
class StaffMember extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
