<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->date('added_date')->nullable();
            $table->string('tip_title')->nullable();
            $table->text('tip_text')->nullable();
            $table->string('group_name', 50)->nullable();
            $table->boolean('display_yearly')->default(false);
            $table->date('display_date')->nullable();
            $table->date('shown_date')->nullable();
            $table->unsignedTinyInteger('display_day')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tips');
    }
};
