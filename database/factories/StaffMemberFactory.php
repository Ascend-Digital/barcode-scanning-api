<?php

namespace Database\Factories;

use Domain\Users\Models\StaffMember;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Users\Models\StaffMember>
 */
class StaffMemberFactory extends Factory
{
    protected $model = StaffMember::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
        ];
    }
}
