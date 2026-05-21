<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Convert any existing datetime values to time-only before changing type
        DB::statement("UPDATE picks SET game_time = TIME(game_time) WHERE game_time IS NOT NULL");

        // Change column from datetime to time
        DB::statement("ALTER TABLE picks MODIFY COLUMN game_time TIME NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE picks MODIFY COLUMN game_time DATETIME NULL");
    }
};
