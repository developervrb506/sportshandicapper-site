<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('live_odds', function (Blueprint $table) {
            $table->id();
            $table->string('event_id')->index();
            $table->string('sport_key')->index();
            $table->string('sport_title');
            $table->dateTime('commence_time')->index();
            $table->string('home_team');
            $table->string('away_team');
            $table->string('bookmaker_key');
            $table->string('bookmaker_title');
            $table->string('market_key');
            $table->json('outcomes');
            $table->dateTime('last_update')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'bookmaker_key', 'market_key'], 'live_odds_event_book_market_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('live_odds');
    }
};
