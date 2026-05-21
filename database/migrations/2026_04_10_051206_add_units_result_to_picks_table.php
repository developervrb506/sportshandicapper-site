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
        Schema::table('picks', function (Blueprint $table) {
            $table->decimal('units_result', 8, 2)->nullable()->after('units');
        });
    }

    public function down()
    {
        Schema::table('picks', function (Blueprint $table) {
            $table->dropColumn('units_result');
        });
    }
};
