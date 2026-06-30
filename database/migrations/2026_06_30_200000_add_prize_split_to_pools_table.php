<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pools', function (Blueprint $table) {
            $table->unsignedTinyInteger('system_share_percent')->nullable()->after('entry_fee');
            $table->unsignedTinyInteger('winner_share_percent')->nullable()->after('system_share_percent');
        });
    }

    public function down(): void
    {
        Schema::table('pools', function (Blueprint $table) {
            $table->dropColumn(['system_share_percent', 'winner_share_percent']);
        });
    }
};
