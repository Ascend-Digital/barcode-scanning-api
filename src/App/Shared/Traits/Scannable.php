<?php

namespace App\Shared\Traits;

use Domain\Codes\Contracts\ScannableModel;
use Domain\Codes\Models\Code;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Scannable
{
    public static function bootScannable(): void
    {
        static::created(function (ScannableModel $model) {
            /**
             * @var $barcode Code
             */
            $barcode = $model->barcode()->make();
            $barcode->company()->associate($model->getCompanyId());
            $barcode->save();
        });
    }

    public function barcode(): MorphOne
    {
        return $this->morphOne(Code::class, 'owner');
    }
}
