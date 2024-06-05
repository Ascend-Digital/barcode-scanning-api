<?php

namespace App\Nova\Resources;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

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
            HasMany::make('Order Items', 'items', OrderItem::class),
        ];
    }
}
