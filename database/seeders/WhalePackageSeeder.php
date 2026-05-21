<?php

namespace Database\Seeders;

use App\Models\WhalePackage;
use Illuminate\Database\Seeder;

class WhalePackageSeeder extends Seeder
{
    public function run()
    {
        WhalePackage::create([
            'title' => 'NFL Whale Package',
            'description' => 'Premium NFL picks with exclusive insider analysis. Get access to our highest-confidence picks and detailed breakdowns.',
            'price' => 499.99,
            'duration' => 'Season',
            'duration_days' => 120,
            'features' => ['All NFL Picks', 'Exclusive Whale Analysis', 'Direct Line Access', 'Priority Support', 'Custom Bet Sizing'],
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}
