<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('betting_consensuses', function (Blueprint $table) {
            $table->id();
            $table->string('sport');
            $table->string('league');
            $table->string('home_team');
            $table->string('away_team');
            $table->dateTime('game_date');
            $table->string('moneyline_home')->nullable();
            $table->string('moneyline_away')->nullable();
            $table->string('spread_home')->nullable();
            $table->string('spread_away')->nullable();
            $table->string('total_over')->nullable();
            $table->string('total_under')->nullable();
            $table->decimal('public_pct_home', 5, 1)->default(50);
            $table->decimal('public_pct_away', 5, 1)->default(50);
            $table->decimal('money_pct_home', 5, 1)->nullable();
            $table->decimal('money_pct_away', 5, 1)->nullable();
            $table->string('venue')->nullable();
            $table->string('broadcast')->nullable();
            $table->timestamps();
            $table->index(['sport', 'league', 'game_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('betting_consensuses');
    }
};
