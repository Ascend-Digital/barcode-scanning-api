<?php

namespace Database\Seeders;

use Domain\Codes\Models\Code;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CodeSeeder extends Seeder
{
    const CHUNK_SIZE = 50;

    public function run(): void
    {
        /**
         * @var Model $scannableModel
         */
        collect(config('scannable.models'))
            ->each(fn (string $scannableModel) => $scannableModel::with('company')
                ->chunkById(self::CHUNK_SIZE, fn (Collection $collection) => $collection
                    ->each(fn (Model $model) => Code::factory(['company_id' => $model->company->id])
                        ->for($model, 'owner')
                        ->create()
                    )
                )
            );
    }
}
