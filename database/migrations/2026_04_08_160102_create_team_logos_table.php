<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_logos', function (Blueprint $table) {
            $table->id();
            $table->string('team_name');
            $table->string('sport'); // NFL, NBA, NHL, MLB, NCAAF, NCAAB
            $table->string('logo_path')->nullable(); // Path to logo image
            $table->string('abbreviation')->nullable(); // e.g., NE, LAL
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['team_name', 'sport']);
            $table->index('sport');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_logos');
    }
};
