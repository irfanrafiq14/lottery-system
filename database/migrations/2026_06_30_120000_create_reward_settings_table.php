<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reward_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('system_share_percent')->default(30);
            $table->unsignedTinyInteger('winner_share_percent')->default(70);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reward_settings');
    }
};
