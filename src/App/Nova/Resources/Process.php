<?php

namespace App\Nova\Resources;

use App\Nova\Actions\ExportBarcodes;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Process extends Resource
{
    public static string $model = \Domain\Processes\Models\Process::class;

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
            BelongsTo::make('From Status', 'fromStatus', Status::class),
            BelongsTo::make('To Status', 'toStatus', Status::class),
            BelongsToMany::make('Prerequisite Processes', 'prerequisiteProcesses', Process::class),
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

    public static function relatableQuery(NovaRequest $request, $query): Builder
    {
        if ($request->resource() === OrderItem::class) {
            $orderItem = $request->findResourceOrFail();
            $orderItemProcesses = $orderItem->item()->sole()->processes();

            return $query->whereIn('id', $orderItemProcesses->pluck('id'));
        }

        return parent::relatableQuery($request, $query);
    }
}
