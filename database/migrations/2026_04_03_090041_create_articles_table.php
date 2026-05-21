<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('category')->default('general');
            $table->string('sport')->nullable();
            $table->string('author')->default('INSPIN Staff');
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index(['category', 'sport', 'is_published', 'published_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
