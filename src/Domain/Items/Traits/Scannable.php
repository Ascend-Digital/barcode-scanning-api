<?php

namespace Domain\Items\Traits;

use Domain\Codes\Models\Code;

trait Scannable
{
    public static function bootScannable()
    {
        // generate barcode image here?
        static::created(function ($model) {
            $model->barcode()->create(['company_id' => $model->company_id, 'code' => $model->name]);
        });
    }

    public function barcode()
    {
        return $this->morphOne(Code::class, 'owner');
    }
}
