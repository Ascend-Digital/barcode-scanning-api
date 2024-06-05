<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prerequisite_process', function (Blueprint $table) {
            $table->foreignId('process_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('prerequisite_id')->constrained('processes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->primary(['process_id', 'prerequisite_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prerequisite_process');
    }
};
