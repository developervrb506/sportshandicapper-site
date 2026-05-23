<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') { return; }
        DB::statement('ALTER TABLE articles MODIFY COLUMN author VARCHAR(255) NULL DEFAULT NULL');
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') { return; }
        DB::statement("ALTER TABLE articles MODIFY COLUMN author VARCHAR(255) NOT NULL DEFAULT 'INSPIN Staff'");
    }
};
