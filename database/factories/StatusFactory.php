<?php

namespace Database\Factories;

use Domain\Statuses\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    protected $model = Status::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
