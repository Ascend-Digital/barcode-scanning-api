<?php

namespace App\Nova\Resources;

use App\Nova\Actions\ExportBarcodes;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Item extends Resource
{
    public static string $model = \Domain\Orders\Models\Item::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
            BelongsTo::make('Company'),
            BelongsToMany::make('Storage Locations', 'storageLocations', StorageLocation::class),
            //            BelongsToMany::make('Processes', 'processes', Process::class),
        ];
    }

    // TODO make Nova action to perform process on order item

    public function actions(NovaRequest $request): array
    {
        return [
            (new ExportBarcodes)
                ->confirmText(__('Please select a barcode type.'))
                ->confirmButtonText(__('Generate PDF')),
        ];
    }
}
