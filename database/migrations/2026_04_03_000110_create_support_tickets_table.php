<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('source_system', 50)->default('legacy');
            $table->string('external_id', 100)->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('status', 50)->default('open');
            $table->string('priority', 30)->nullable();
            $table->timestamp('legacy_created_at')->nullable();
            $table->timestamp('legacy_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
