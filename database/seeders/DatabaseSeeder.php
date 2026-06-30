<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Pool;
use Database\Seeders\LandingSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Pool::insert([
            [
                'name' => 'Bronze',
                'slug' => 'bronze',
                'entry_fee' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Silver',
                'slug' => 'silver',
                'entry_fee' => 50,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gold',
                'slug' => 'gold',
                'entry_fee' => 100,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Admin::create([
            'name' => 'System Admin',
            'email' => 'admin@jeetorewards.test',
            'password' => 'password',
        ]);

        \App\Models\RewardSetting::create([
            'system_share_percent' => 30,
            'winner_share_percent' => 70,
        ]);

        $this->call(LandingSeeder::class);
    }
}
