<?php

namespace Database\Factories;

use Domain\Companies\Models\Company;
use Domain\Users\Models\StaffMember;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffMemberFactory extends Factory
{
    protected $model = StaffMember::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
        ];
    }
}
