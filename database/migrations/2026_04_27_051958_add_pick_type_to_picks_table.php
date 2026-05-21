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
    public function up(): void
    {
        Schema::table('picks', function (Blueprint $table) {
            $table->string('pick_type')->nullable()->after('sport');
        });
    }

    public function down(): void
    {
        Schema::table('picks', function (Blueprint $table) {
            $table->dropColumn('pick_type');
        });
    }
};
