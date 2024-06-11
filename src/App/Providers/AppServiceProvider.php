<?php

namespace App\Providers;

use Domain\Orders\Models\Item;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderItem;
use Domain\Processes\Models\Process;
use Domain\Statuses\Models\Status;
use Domain\Users\Models\StaffMember;
use Domain\Users\Models\User;
use Domain\Warehouses\Models\StorageLocation;
use Domain\Warehouses\Models\Warehouse;
use Domain\Warehouses\Models\Workstation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
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

        Gate::before(function (User $user) {
            if (str_ends_with($user->email, '@ascend.agency')) {
                return true;
            }
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
            'status' => Status::class,
            'order_item' => OrderItem::class,
        ]);

    }
}
