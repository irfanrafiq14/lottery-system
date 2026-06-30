<?php

use App\Models\Entry;
use App\Models\RewardSetting;
use App\Models\Winner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('winners', function (Blueprint $table) {
            $table->unsignedInteger('prize_amount')->default(0)->after('week_number');
        });

        $settings = RewardSetting::current();

        Winner::query()->with('pool')->each(function (Winner $winner) use ($settings) {
            if (! $winner->pool) {
                return;
            }

            $participants = Entry::withTrashed()
                ->where('pool_id', $winner->pool_id)
                ->where('week_number', $winner->week_number)
                ->where('status', 'approved')
                ->count();

            $winner->update([
                'prize_amount' => $settings->calculatePrize($participants, $winner->pool->entry_fee)['winner'],
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('winners', function (Blueprint $table) {
            $table->dropColumn('prize_amount');
        });
    }
};
