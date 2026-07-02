<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('referral_code', 12)->nullable()->unique()->after('password');
            $table->foreignId('referred_by_id')->nullable()->after('referral_code')->constrained('users')->nullOnDelete();
        });

        User::query()->whereNull('referral_code')->each(function (User $user) {
            $user->update(['referral_code' => User::generateUniqueReferralCode()]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('referred_by_id');
            $table->dropColumn('referral_code');
        });
    }
};
