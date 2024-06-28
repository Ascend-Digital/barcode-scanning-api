<?php

namespace Database\Seeders;

use Domain\Companies\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::factory(50)
            ->hasStaffMembers(5)
            ->hasItems(50)
            ->createQuietly();
    }
}
