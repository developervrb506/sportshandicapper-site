<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@inspin.local',
            'password' => Hash::make('password123'),
        ]);

        User::factory(5)->create();

        $this->call([
            TipSeeder::class,
            SupportTicketSeeder::class,
            ContestSeeder::class,
            ArticleSeeder::class,
            BettingConsensusSeeder::class,
            PackageSeeder::class,
            WhalePackageSeeder::class,
            PickSeeder::class,
            TeamLogoSeeder::class,
            ExpertSeeder::class,
        ]);
    }
}
