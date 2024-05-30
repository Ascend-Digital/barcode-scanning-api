<?php

namespace App\Nova\Actions;

use App\Notifications\PDFGenerated;
use Barryvdh\DomPDF\Facade\Pdf;
use Domain\Users\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class ExportBarcodes extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    private Authenticatable|User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function handle(ActionFields $fields, Collection $models): void
    {
        $codeType = $fields['type'] === 'C39' ? new DNS1D() : new DNS2D();

        $barcodes = $models->map(function (Model $model) use ($codeType, $fields) {
            return [
                'name' => $model->name,
                'company' => $model->company->name,
                'image' => $codeType->getBarcodePNG((string) $model->barcode->barcode, $fields['type']),
            ];
        });

        $pdf = PDF::loadView('barcodes', ['barcodes' => $barcodes])->setPaper('a4');

        $filename = uniqid().'.pdf';

        Storage::disk('scannables')->put($filename, $pdf->output());
        $this->user->notify(new PDFGenerated($filename));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Select::make('Type')->options([
                'QRCODE' => 'QR',
                'C39' => 'Barcode',
            ])->rules('required'),
        ];
    }
}
