<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $experts = [
            [
                'name' => 'John Smith',
                'slug' => 'john-smith',
                'bio' => 'Former professional football player with 10+ years of betting analysis experience.',
                'specialty' => 'NFL',
                'is_active' => true,
            ],
            [
                'name' => 'Sarah Johnson',
                'slug' => 'sarah-johnson',
                'bio' => 'NBA analytics specialist with a background in data science.',
                'specialty' => 'NBA',
                'is_active' => true,
            ],
            [
                'name' => 'Mike Davis',
                'slug' => 'mike-davis',
                'bio' => 'MLB expert with deep knowledge of pitching matchups and ballpark factors.',
                'specialty' => 'MLB',
                'is_active' => true,
            ],
            [
                'name' => 'Emily Chen',
                'slug' => 'emily-chen',
                'bio' => 'College basketball analyst specializing in NCAA tournament predictions.',
                'specialty' => 'NCAAB',
                'is_active' => true,
            ],
            [
                'name' => 'David Wilson',
                'slug' => 'david-wilson',
                'bio' => 'Multi-sport handicapper with expertise in NHL and MLB.',
                'specialty' => null, // covers all sports
                'is_active' => true,
            ],
        ];

        foreach ($experts as $expert) {
            \App\Models\Expert::create($expert);
        }

        $this->command->info('Expert seeder created ' . count($experts) . ' experts.');
    }
}
