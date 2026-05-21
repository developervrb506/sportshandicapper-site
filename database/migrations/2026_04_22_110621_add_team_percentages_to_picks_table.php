<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        \Illuminate\Support\Facades\Schema::table('picks', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->unsignedTinyInteger('team1_percent')->nullable()->after('team2_rotation');
            $table->unsignedTinyInteger('team2_percent')->nullable()->after('team1_percent');
        });
    }

    public function down(): void
    {
        \Illuminate\Support\Facades\Schema::table('picks', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn(['team1_percent', 'team2_percent']);
        });
    }
};
