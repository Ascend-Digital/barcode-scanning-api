<?php

use Domain\Items\Models\Item;
use Domain\Orders\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_order', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Item::class)->constrained()->onDelete('cascade');
            $table->timestamp('completed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_order');
    }
};
