<?php

use Domain\Items\Models\OrderItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_item_process', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('item_order')->onDelete('cascade');
            $table->foreignIdFor(\Domain\Processes\Models\Process::class)->constrained();
            $table->timestamp('completed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_order_process');
    }
};
