<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scannable_actions', function (Blueprint $table) {
            $table->id();
            $table->string('owner_type');
            $table->string('title');
            $table->string('endpoint')->nullable();
            $table->enum('method', ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scannable_actions');
    }
};
