<?php

namespace Database\Seeders;

use Domain\Users\Models\StaffMember;
use Illuminate\Database\Seeder;

class StaffMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StaffMember::factory(10)->createQuietly();
    }
}
