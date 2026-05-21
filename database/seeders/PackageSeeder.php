<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        // Clear existing packages
        Package::query()->delete();

        $packages = [
            // 1. Free Trial - 7 Day Trial
            [
                'name' => 'Free Trial',
                'slug' => 'free-trial',
                'description' => 'Try INSPIN free for 7 days. Full access to all picks and analysis.',
                'price' => 0.00,
                'duration' => '7 Days',
                'duration_days' => 7,
                'features' => [
                    'Full access for 7 days',
                    'All Sport Picks',
                    'Simulation Model Access',
                    'Daily Consensus Data',
                    'No credit card required',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],

            // 2. 1 Week - $24.99
            [
                'name' => '1 Week',
                'slug' => '1-week',
                'description' => 'One week of premium picks and analysis.',
                'price' => 24.99,
                'duration' => '1 Week',
                'duration_days' => 7,
                'features' => [
                    'All Sport Picks',
                    'Simulation Model Access',
                    'Daily Consensus Data',
                    'Betting Trends',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],

            // 3. 2 Weeks - $49.99
            [
                'name' => '2 Weeks',
                'slug' => '2-weeks',
                'description' => 'Two weeks of premium picks and analysis.',
                'price' => 49.99,
                'duration' => '2 Weeks',
                'duration_days' => 14,
                'features' => [
                    'All Sport Picks',
                    'Simulation Model Access',
                    'Daily Consensus Data',
                    'Betting Trends',
                    'Save $25 vs Weekly',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],

            // 4. 1 Month - $99.99
            [
                'name' => '1 Month',
                'slug' => 'monthly',
                'description' => 'Full month access to all INSPIN picks and analysis.',
                'price' => 99.99,
                'duration' => '1 Month',
                'duration_days' => 30,
                'features' => [
                    'All Sport Picks',
                    'Simulation Model Access',
                    'Daily Consensus Data',
                    'Betting Trends',
                    '24/7 Support',
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],

            // 5. 3 Months - $199.99
            [
                'name' => '3 Months',
                'slug' => 'quarterly',
                'description' => 'Three months of premium picks at a discounted rate.',
                'price' => 199.99,
                'duration' => '3 Months',
                'duration_days' => 90,
                'features' => [
                    'All Sport Picks',
                    'Simulation Model Access',
                    'Daily Consensus Data',
                    'Betting Trends',
                    '24/7 Support',
                    'Save $100 vs Monthly',
                ],
                'is_active' => true,
                'sort_order' => 5,
            ],

            // 6. 6 Months - $299.99
            [
                'name' => '6 Months',
                'slug' => 'semi-annual',
                'description' => 'Six months of premium access at great value.',
                'price' => 299.99,
                'duration' => '6 Months',
                'duration_days' => 180,
                'features' => [
                    'All Sport Picks',
                    'Simulation Model Access',
                    'Daily Consensus Data',
                    'Betting Trends',
                    '24/7 Support',
                    'Save $300 vs Monthly',
                ],
                'is_active' => true,
                'sort_order' => 6,
            ],

            // 7. 9 Months - $399.99
            [
                'name' => '9 Months',
                'slug' => 'nine-months',
                'description' => 'Nine months of premium access for dedicated bettors.',
                'price' => 399.99,
                'duration' => '9 Months',
                'duration_days' => 270,
                'features' => [
                    'All Sport Picks',
                    'Simulation Model Access',
                    'Daily Consensus Data',
                    'Betting Trends',
                    '24/7 Support',
                    'Save $500 vs Monthly',
                ],
                'is_active' => true,
                'sort_order' => 7,
            ],

            // 8. 12 Months - $499.99
            [
                'name' => '12 Months',
                'slug' => 'annual',
                'description' => 'Full year access with the best standard value. Never miss a winning pick.',
                'price' => 499.99,
                'duration' => '12 Months',
                'duration_days' => 365,
                'features' => [
                    'All Sport Picks',
                    'Simulation Model Access',
                    'Daily Consensus Data',
                    'Betting Trends',
                    '24/7 Support',
                    'Priority Support',
                    'Save $700 vs Monthly',
                ],
                'is_active' => true,
                'sort_order' => 8,
            ],

            // 9. Whale Package - $999.99 (1 Year + 10-Star Picks)
            [
                'name' => 'Whale Package',
                'slug' => 'whale-package',
                'description' => '1 Year access plus all exclusive 10-Star Picks. The ultimate package for serious bettors.',
                'price' => 999.99,
                'duration' => '12 Months',
                'duration_days' => 365,
                'features' => [
                    'Everything in 12 Months',
                    'Exclusive 10-Star Picks',
                    'Whale-Only Analysis',
                    'Priority Support',
                    'Direct Expert Access',
                    'Early Pick Access',
                    'Highest Unit Plays',
                ],
                'is_active' => true,
                'sort_order' => 9,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::create($pkg);
        }

        $this->command->info('All 9 subscription packages seeded successfully!');
    }
}
