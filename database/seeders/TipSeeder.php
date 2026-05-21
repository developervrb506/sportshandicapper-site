<?php

namespace Database\Seeders;

use App\Models\Tip;
use Illuminate\Database\Seeder;

class TipSeeder extends Seeder
{
    public function run()
    {
        Tip::factory()->count(25)->create();
    }
}
