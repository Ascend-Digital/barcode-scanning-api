<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Company extends Filter
{
    public $component = 'select-filter';

    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->whereHas('company', function (Builder $builder) use ($value) {
            $builder->where('name', $value);
        });
    }

    public function options(NovaRequest $request)
    {
        return \Domain\Companies\Models\Company::pluck('name');
    }
}
