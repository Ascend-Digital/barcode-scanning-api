<?php

use Domain\Items\Models\Item;
use Domain\Processes\Models\Process;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_process', function (Blueprint $table) {
            $table->foreignIdFor(Item::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Process::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('completed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_process');
    }
};
