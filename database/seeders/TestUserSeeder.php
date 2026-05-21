<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $testAccounts = [
            ['name'=>'Free Trial User',        'email'=>'free@test.com',  'package'=>'free-trial',    'max_stars'=>1,  'days'=>7],
            ['name'=>'Basic User ($24.99)',     'email'=>'basic@test.com', 'package'=>'1-week',        'max_stars'=>2,  'days'=>7],
            ['name'=>'Mid Tier User ($199.99)', 'email'=>'mid@test.com',   'package'=>'semi-annual',   'max_stars'=>5,  'days'=>90],
            ['name'=>'Full Access (Whale)',     'email'=>'full@test.com',  'package'=>'whale-package', 'max_stars'=>10, 'days'=>365],
        ];

        foreach ($testAccounts as $account) {
            $user = User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name'              => $account['name'],
                    'password'          => Hash::make('password'),
                    'role'              => 'subscriber',
                    'email_verified_at' => Carbon::now(), // test accounts are pre-verified
                ]
            );

            UserPackage::where('user_id', $user->id)->update(['is_active' => false]);

            $package = Package::where('slug', $account['package'])->first();

            UserPackage::create([
                'user_id'     => $user->id,
                'package_id'  => $package?->id,
                'starts_at'   => Carbon::now()->subDay(), // started yesterday
                'expires_at'  => Carbon::now()->addDays($account['days']),
                'is_active'   => true,
                'max_stars'   => $account['max_stars'],
                'units_total' => 0.00,
                'status_note' => 'active',
            ]);

            $this->command->info("✓ {$account['email']} | {$account['max_stars']}★ | expires in {$account['days']} days");
        }

        $this->command->info("\nAll passwords: password");
    }
}
