<?php

namespace Database\Seeders;

use Domain\Companies\Models\Company;
use Domain\Statuses\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        Status::factory(['name' => 'Picked'])->create();
        Status::factory(['name' => 'Manufactured'])->create();

        $companies = Company::all();

        foreach ($companies as $company) {
            Status::factory(10)
                ->for($company)
                ->hasOrders()
                ->recycle($company)
                ->createQuietly();
        }
    }
}
