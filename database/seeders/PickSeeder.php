<?php

namespace Database\Seeders;

use App\Models\Pick;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PickSeeder extends Seeder
{
    public function run()
    {
        // Clear existing picks
        Pick::query()->delete();

        $today = Carbon::today();
        $teams = [
            ['NFL' => [['Buffalo Bills', 'Miami Dolphins'], ['Kansas City Chiefs', 'Las Vegas Raiders'], ['Dallas Cowboys', 'Philadelphia Eagles']]],
            ['NBA' => [['Los Angeles Lakers', 'Boston Celtics'], ['Golden State Warriors', 'Milwaukee Bucks'], ['Miami Heat', 'New York Knicks']]],
            ['NHL' => [['Edmonton Oilers', 'Florida Panthers'], ['Toronto Maple Leafs', 'Tampa Bay Lightning']]],
            ['MLB' => [['New York Yankees', 'Boston Red Sox'], ['Los Angeles Dodgers', 'San Francisco Giants']]],
            ['NCAAF' => [['Alabama Crimson Tide', 'Georgia Bulldogs'], ['Ohio State Buckeyes', 'Michigan Wolverines']]],
            ['NCAAB' => [['Duke Blue Devils', 'North Carolina Tar Heels'], ['Kentucky Wildcats', 'Kansas Jayhawks']]],
        ];

        $sports = ['NFL', 'NBA', 'NHL', 'MLB', 'NCAAF', 'NCAAB'];
        $pickTypes = ['Moneyline', 'Spread', 'Over', 'Under', 'Team Total', '1H Spread', '1H Moneyline'];
        $experts = ['INSPIN Staff', 'Pro Capper', 'Whale Expert', 'Senior Analyst'];
        $venues = ['Allegiant Stadium', 'Lambeau Field', 'TD Garden', 'Madison Square Garden', 'Staples Center', 'Wrigley Field', 'Fenway Park', 'Yankee Stadium'];

        $pickId = 1;

        foreach ($sports as $sport) {
            $matchups = $teams[$sport][0] ?? [];
            foreach ($matchups as $idx => $matchup) {
                $stars = $this->getRandomStars();
                $result = $this->getRandomResult();
                $units = $this->calculateUnits($stars, $result);

                Pick::create([
                    'sport' => $sport,
                    'game_date' => $today->copy()->addDays(rand(-2, 3)),
                    'game_time' => sprintf('%02d:%02d:00', rand(13, 23), rand(0, 5) * 10),
                    'team1_name' => $matchup[0],
                    'team1_rotation' => 100 + ($pickId * 3 - 2),
                    'team2_name' => $matchup[1],
                    'team2_rotation' => 100 + ($pickId * 3 - 1),
                    'venue' => $venues[array_rand($venues)],
                    'pick' => $pickTypes[array_rand($pickTypes)],
                    'stars' => $stars,
                    'result' => $result,
                    'units' => $units,
                    'expert_name' => $experts[array_rand($experts)],
                    'is_active' => true,
                    'is_whale_exclusive' => $stars === 10,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $pickId++;
            }
        }

        $this->command->info('Test picks seeded successfully!');
    }

    private function getRandomStars(): int
    {
        $weights = [30, 25, 20, 15, 9, 1]; // 1-star most common, 10-star rarest
        $options = [1, 2, 3, 4, 5, 10];
        
        $total = array_sum($weights);
        $rand = rand(1, $total);
        $cumulative = 0;
        
        foreach ($weights as $i => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $options[$i];
            }
        }
        
        return 1;
    }

    private function getRandomResult(): string
    {
        $results = ['pending', 'win', 'loss', 'push'];
        $weights = [20, 45, 30, 5]; // 45% win, 30% loss, 5% push, 20% pending
        
        $total = array_sum($weights);
        $rand = rand(1, $total);
        $cumulative = 0;
        
        foreach ($weights as $i => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $results[$i];
            }
        }
        
        return 'pending';
    }

    private function calculateUnits(int $stars, string $result): ?float
    {
        if ($result === 'pending') {
            return null;
        }
        
        $baseUnits = [
            1 => 1.00,
            2 => 2.00,
            3 => 3.00,
            4 => 4.00,
            5 => 5.00,
            10 => 10.00,
        ];
        
        $base = $baseUnits[$stars] ?? 1.00;
        
        return match ($result) {
            'win' => $base,
            'loss' => -$base * 1.10, // -110 odds
            'push' => 0.00,
            default => null,
        };
    }
}
