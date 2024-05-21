<?php

namespace Database\Seeders;

use Domain\Companies\Models\Company;
use Domain\Processes\Models\Process;
use Domain\Statuses\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            Status::factory()
                ->has(Process::factory(), 'processesWithFromStatus')
                ->has(Process::factory(), 'processesWithToStatus')
                ->hasOrders()
                ->recycle($company)
                ->createQuietly();
        }
    }
}
