<?php

namespace Database\Factories;

use Domain\Barcodes\Models\Barcode;
use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarcodeFactory extends Factory
{
    protected $model = Barcode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'barcode' => fake()->ean13(),
        ];
    }
}
