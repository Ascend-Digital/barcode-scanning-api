<?php

namespace App\Shared\Traits;

use Domain\Barcodes\Contracts\ScannableModel;
use Domain\Barcodes\Models\Barcode;
use Domain\Barcodes\Models\Scan;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\UniqueConstraintViolationException;

trait Scannable
{
    public static function bootScannable(): void
    {
        static::created(function (ScannableModel $model) {
            try {
                /**
                 * @var $barcode Barcode
                 */
                $barcode = $model->barcode()->make([
                    'barcode' => fake()->ean13(),
                ]);
                $barcode->company()->associate($model->getCompanyId());
                $barcode->save();
            } catch (UniqueConstraintViolationException $e) {
                $model->delete();
                throw $e;
            }
        });
    }

    public function logScan(): void
    {
        $scan = $this->scans()->make([
            'scanned_at' => now(),
        ]);

        $scan->company()->associate($this->getCompanyId());
        $scan->save();
    }

    public function barcode(): MorphOne
    {
        return $this->morphOne(Barcode::class, 'owner');
    }

    public function scans(): MorphMany
    {
        return $this->morphMany(Scan::class, 'owner');
    }

    public function availableActions(): array
    {
        return config('scannable.actions.'.get_class($this));
    }
}
