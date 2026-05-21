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
        Schema::table('user_packages', function (Blueprint $table) {
            $table->decimal('units_total', 8, 2)->default(0.00)->after('is_active');
            $table->unsignedTinyInteger('max_stars')->default(1)->after('units_total');
            $table->string('status_note')->nullable()->after('max_stars'); // 'active' | 'extended' | 'expired'
        });
    }

    public function down(): void
    {
        Schema::table('user_packages', function (Blueprint $table) {
            $table->dropColumn(['units_total', 'max_stars', 'status_note']);
        });
    }
};
