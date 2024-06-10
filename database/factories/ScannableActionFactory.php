<?php

namespace Database\Factories;

use Domain\Barcodes\Models\ScannableAction;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScannableActionFactory extends Factory
{
    protected $model = ScannableAction::class;

    public function definition(): array
    {
        $ownerTypes = $this->scannableModels();

        return [
            'owner_type' => $this->faker->randomElement($ownerTypes),
            'title' => $this->faker->sentence(),
            'method' => $this->faker->randomElement(['GET', 'POST', 'PATCH', 'PUT', 'DELETE']),
        ];
    }

    private function scannableModels(): array
    {
        $modelClasses = config('scannable.models');

        return array_map(function ($modelClass) {
            return app($modelClass)->getMorphClass();
        }, $modelClasses);
    }
}
