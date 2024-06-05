<?php

namespace Database\Factories;

use Domain\Companies\Models\Company;
use Domain\Processes\Models\Process;
use Domain\Statuses\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcessFactory extends Factory
{
    protected $model = Process::class;

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
