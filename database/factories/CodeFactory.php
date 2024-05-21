<?php

namespace Database\Factories;

use Domain\Codes\Models\Code;
use Domain\Companies\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Codes\Code>
 */
class CodeFactory extends Factory
{
    protected $model = Code::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
        ];
    }
}
