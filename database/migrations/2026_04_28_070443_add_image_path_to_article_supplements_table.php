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
        Schema::table('article_supplements', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('external_url');
            $table->text('ai_content')->nullable()->after('image_path'); // stores Claude-generated JSON
        });
    }

    public function down(): void
    {
        Schema::table('article_supplements', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'ai_content']);
        });
    }
};
