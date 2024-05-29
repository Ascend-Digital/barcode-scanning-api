<?php

namespace App\Providers;

use Domain\Items\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Processes\Models\Process;
use Domain\Users\Models\StaffMember;
use Domain\Users\Models\User;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return '\Database\Factories\\'.class_basename($modelName).'Factory';
        });

        Relation::enforceMorphMap([
            'item' => Item::class,
            'warehouse' => Warehouse::class,
            'workstation' => Workstation::class,
            'storage_location' => StorageLocation::class,
            'staff_member' => StaffMember::class,
            'process' => Process::class,
            'order' => Order::class,
            'user' => User::class,
        ]);

    }
}
