<?php

namespace Domain\Subscriptions\Models;

use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
