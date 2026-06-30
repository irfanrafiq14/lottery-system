<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->json('hero')->nullable();
            $table->json('statistics')->nullable();
            $table->json('jackpot')->nullable();
            $table->json('download')->nullable();
            $table->json('newsletter')->nullable();
            $table->json('footer')->nullable();
            $table->json('seo')->nullable();
            $table->json('theme')->nullable();
            $table->json('analytics')->nullable();
            $table->json('popup')->nullable();
            $table->json('announcement')->nullable();
            $table->json('maintenance')->nullable();
            $table->timestamps();
        });

        Schema::create('landing_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('step_number');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->default('fa-user-plus');
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('landing_features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->default('fa-shield-halved');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('landing_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country')->nullable();
            $table->text('review');
            $table->string('photo')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('landing_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('landing_winners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('prize_amount')->default(0);
            $table->string('country')->nullable();
            $table->date('won_at')->nullable();
            $table->string('image')->nullable();
            $table->string('pool_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('subscribed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('landing_winners');
        Schema::dropIfExists('landing_faqs');
        Schema::dropIfExists('landing_testimonials');
        Schema::dropIfExists('landing_features');
        Schema::dropIfExists('landing_steps');
        Schema::dropIfExists('site_settings');
    }
};
