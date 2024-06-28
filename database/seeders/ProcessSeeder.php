<?php

namespace Database\Seeders;

use Domain\Companies\Models\Company;
use Domain\Orders\Models\Item;
use Domain\Processes\Models\Process;
use Domain\Statuses\Models\Status;
use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        $items = Item::all();
        $statuses = Status::all();

        foreach ($companies as $company) {
            Process::factory()
                ->state(
                    [
                        'from_status' => $statuses->where('company_id', $company->id)->random(),
                        'to_status' => $statuses->where('company_id', $company->id)->random(),
                    ]
                )
                ->hasAttached(
                    $items->where('company_id', $company->id)->random(50)
                )
                ->recycle($company)
                ->createQuietly();
        }
    }
}
