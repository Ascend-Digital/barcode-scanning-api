<?php

namespace App\Nova\Resources;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class OrderItem extends Resource
{
    public static string $model = \Domain\Orders\Models\OrderItem::class;

    public static $displayInNavigation = false;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Order'),
            BelongsTo::make('Item'),
            BelongsToMany::make('Processes', 'processes', Process::class),
        ];
    }

    //    public static function authorizedToCreate(Request $request)
    //    {
    //        return false;
    //    }
    //
    //    public function authorizedToDelete(Request $request)
    //    {
    //        return false;
    //    }
    //
    //    public function authorizedToUpdate(Request $request)
    //    {
    //        return false;
    //    }
}
