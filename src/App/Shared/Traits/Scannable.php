<?php

namespace App\Shared\Traits;

use App\Shared\Urls\UrlGenerator;
use Domain\Barcodes\Contracts\ScannableModel;
use Domain\Barcodes\Models\Barcode;
use Domain\Barcodes\Models\ScannableAction;
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

    public function barcode(): MorphOne
    {
        return $this->morphOne(Barcode::class, 'owner');
    }

    public function actions(?array $params = null, ?string $key = null)
    {
        return ScannableAction::where('owner_type', $this->getMorphClass())
            ->where('key', $key)
            ->get()
            ->map(function (ScannableAction $action) use ($params) {
                if ($action->endpoint !== null) {
                    $action->endpoint = UrlGenerator::generateActionUrl($action, $params);
                }

                return $action;
            })->reject(function (ScannableAction $action) {
                return $action->method !== null && $action->endpoint === null;
            });
    }
}
