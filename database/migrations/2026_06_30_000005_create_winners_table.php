<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pool_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('week_number');
            $table->timestamps();

            $table->unique(['pool_id', 'week_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('winners');
    }
};
