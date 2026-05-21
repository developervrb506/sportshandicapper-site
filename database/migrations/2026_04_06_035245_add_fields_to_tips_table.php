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
        Schema::table('tips', function (Blueprint $table) {
            $table->string('expert_name')->nullable()->after('group_name');
            $table->string('matchup')->nullable()->after('expert_name');
            $table->integer('confidence')->nullable()->after('matchup');
            $table->string('result')->nullable()->after('confidence');
            $table->text('analysis')->nullable()->after('result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->dropColumn(['expert_name', 'matchup', 'confidence', 'result', 'analysis']);
        });
    }
};
