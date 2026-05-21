<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('picks', function (Blueprint $table) {
            $table->id();
            $table->string('sport', 50)->nullable(); // NFL, NCAAF, NBA, NCAAB, NHL, MLB
            $table->date('game_date')->nullable();
            $table->time('game_time')->nullable();
            $table->string('team1_name')->nullable();
            $table->string('team1_logo')->nullable();
            $table->integer('team1_rotation')->nullable();
            $table->string('team2_name')->nullable();
            $table->string('team2_logo')->nullable();
            $table->integer('team2_rotation')->nullable();
            $table->string('venue')->nullable();
            $table->string('pick')->nullable(); // The actual pick recommendation
            $table->string('simulation_result')->nullable(); // Simulated result
            $table->integer('stars')->default(1); // 1, 2, 3, 4, 5, or 10 (10 = Exclusive Whale Package)
            $table->enum('result', ['pending', 'win', 'loss', 'push'])->default('pending');
            $table->decimal('units', 8, 2)->nullable(); // +1.00, -2.20, etc.
            $table->string('expert_name')->nullable();
            $table->string('related_article_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_whale_exclusive')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('picks');
    }
};
