<?php

use Domain\Orders\Models\OrderItem;
use Domain\Processes\Models\Process;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_item_process', function (Blueprint $table) {
            $table->foreignIdFor(OrderItem::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Process::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('completed_at');
            $table->primary(['order_item_id', 'process_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item_process');
    }
};
