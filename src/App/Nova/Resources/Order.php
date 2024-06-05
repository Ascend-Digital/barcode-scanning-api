<?php

namespace App\Nova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class Order extends Resource
{
    public static string $model = \Domain\Orders\Models\Order::class;

    public static $title = 'id';

    public static $search = [
        'id',
        'name',
    ];

    public function fields(NovaRequest $request): array
    {
        // TODO this will be readonly
        return [
            ID::make()->sortable(),
            BelongsTo::make('Company')->readonly(),
            BelongsTo::make('Status')->readonly(),
            HasMany::make('Order Items'),
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
