<?php

namespace App\Nova\Resources;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class OrderItem extends Resource
{
    public static string $model = \Domain\Orders\Models\OrderItem::class;

    public static $displayInNavigation = false;

    public static $title = 'id';

    public static $search = [
        'id',
        'item.processes.name',
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Order'),
            BelongsTo::make('Item'),
            Number::make('Quantity')->rules('required', 'integer', 'min:1'),
            BelongsToMany::make('Completed Processes', 'processes', Process::class)
                ->fields(function () {
                    return [
                        DateTime::make('Completed At')->withMeta(['extraAttributes' => ['readonly' => true]])->default(now()),
                    ];
                }),
        ];
    }
}
