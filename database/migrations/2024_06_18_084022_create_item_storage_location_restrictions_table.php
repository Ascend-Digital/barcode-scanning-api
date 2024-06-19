<?php

use Domain\Orders\Models\Item;
use Domain\Warehouses\Models\StorageLocation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_storage_location_restrictions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StorageLocation::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Item::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_storage_location_restrictions');
    }
};
