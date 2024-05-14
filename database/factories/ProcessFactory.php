<?php

namespace Database\Factories;

use Domain\Companies\Models\Company;
use Domain\Processes\Models\Process;
use Domain\Statuses\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Processes\Models\Process>
 */
class ProcessFactory extends Factory
{
    protected $model = Process::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'company_id' => Company::factory(),
            'from_status' => Status::factory(),
            'to_status' => Status::factory(),
        ];
    }
}
