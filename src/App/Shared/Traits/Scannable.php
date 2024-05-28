<?php

namespace App\Shared\Traits;

use Domain\Barcodes\Contracts\ScannableModel;
use Domain\Barcodes\Models\Barcode;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Scannable
{
    public static function bootScannable(): void
    {
        static::created(function (ScannableModel $model) {
            /**
             * @var $barcode Barcode
             */
            $barcode = $model->barcode()->make();
            $barcode->company()->associate($model->getCompanyId());
            $barcode->save();
        });
    }

    public function barcode(): MorphOne
    {
        return $this->morphOne(Barcode::class, 'owner');
    }
}
