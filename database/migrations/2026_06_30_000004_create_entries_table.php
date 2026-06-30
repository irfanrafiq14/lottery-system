<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pool_id')->constrained()->cascadeOnDelete();
            $table->string('transaction_id');
            $table->string('screenshot');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedInteger('week_number');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'pool_id', 'week_number']);
            $table->index('transaction_id');
            $table->index(['pool_id', 'week_number', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
