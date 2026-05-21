<?php

namespace Database\Seeders;

use App\Models\Contest;
use Illuminate\Database\Seeder;

class ContestSeeder extends Seeder
{
    public function run()
    {
        Contest::factory()->count(15)->create();
    }
}
