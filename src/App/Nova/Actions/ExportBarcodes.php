<?php

namespace App\Nova\Actions;

use App\Notifications\PDFGenerated;
use Barryvdh\DomPDF\Facade\Pdf;
use Domain\Barcodes\Enums\BarcodeType;
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
    const BARCODE_WIDTH = 2;

    const BARCODE_HEIGHT = 100;

    const QR_CODE_WIDTH = 15;

    const QR_CODE_HEIGHT = 15;

    use InteractsWithQueue, Queueable;

    private Authenticatable|User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function handle(ActionFields $fields, Collection $models): void
    {
        $type = BarcodeType::from($fields['type']);
        $configuration = $this->barcodeConfiguration($type);

        $barcodes = $models->sortBy('id')->map(function (Model $model) use ($configuration) {
            return [
                'name' => $model->name ?? $model->id,
                'company' => $model->company->name,
                'image' => $configuration['codeType']->getBarcodePNG((string) $model->barcode->barcode,
                    $configuration['type']->value,
                    $configuration['width'],
                    $configuration['height']),
                'barcode' => $configuration['type'] === BarcodeType::C39 ? str_split($model->barcode->barcode) : [],
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

    private function barcodeConfiguration(BarcodeType $type): array
    {
        $config = [
            BarcodeType::C39->value => [
                'codeType' => new DNS1D(),
                'width' => self::BARCODE_WIDTH,
                'height' => self::BARCODE_HEIGHT,
                'type' => $type,
            ],
            BarcodeType::QRCODE->value => [
                'codeType' => new DNS2D(),
                'width' => self::QR_CODE_WIDTH,
                'height' => self::QR_CODE_HEIGHT,
                'type' => $type,
            ],
        ];

        return $config[$type->value];
    }
}
