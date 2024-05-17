<?php

namespace App\Nova\Resources;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    public static array $defaultSort = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        if (static::$defaultSort && empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            return $query->orderBy(static::$defaultSort['column'], static::$defaultSort['direction']);
        }

        return $query;
    }

    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    public static function detailQuery(NovaRequest $request, $query): Builder
    {
        return parent::detailQuery($request, $query);
    }

    public static function relatableQuery(NovaRequest $request, $query): Builder
    {
        return parent::relatableQuery($request, $query);
    }
}
