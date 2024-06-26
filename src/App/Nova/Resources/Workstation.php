<?php

namespace App\Nova\Resources;

use App\Nova\Actions\ExportBarcodes;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Workstation extends Resource
{
    public static string $model = \Domain\Warehouses\Models\Workstation::class;

    public static $title = 'name';

    public static $search = [
        'id',
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
        ];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            (new ExportBarcodes)
                ->confirmText(__('Please select a barcode type.'))
                ->confirmButtonText(__('Generate PDF')),
        ];
    }
}
