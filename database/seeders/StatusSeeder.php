<?php

namespace Database\Seeders;

use Domain\Companies\Models\Company;
use Domain\Orders\Models\Item;
use Domain\Processes\Models\Process;
use Domain\Statuses\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        $items = Item::factory(100)->create();

        foreach ($companies as $company) {
            Status::factory()
                ->has(
                    Process::factory()
                        ->hasAttached(
                            $items->random(10)
                        ),
                    'processesWithFromStatus'
                )
                ->has(
                    Process::factory()
                        ->hasAttached(
                            $items->random(10)
                        ),
                    'processesWithToStatus'
                )
                ->hasOrders()
                ->recycle($company)
                ->createQuietly();
        }
    }
}
