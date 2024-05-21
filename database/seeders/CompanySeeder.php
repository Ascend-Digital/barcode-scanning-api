<?php

namespace Database\Seeders;

use Domain\Companies\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory(50)
            ->hasItems(60)
            ->hasStaffMembers(5)
            ->createQuietly();
    }
}
