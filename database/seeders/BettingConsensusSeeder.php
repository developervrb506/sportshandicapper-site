<?php

namespace Database\Seeders;

use App\Models\BettingConsensus;
use Illuminate\Database\Seeder;

class BettingConsensusSeeder extends Seeder
{
    public function run()
    {
        $games = [
            [
                'sport' => 'Basketball', 'league' => 'NBA',
                'home_team' => 'Boston Celtics', 'away_team' => 'Philadelphia 76ers',
                'game_date' => now()->addHours(20),
                'moneyline_home' => '-180', 'moneyline_away' => '+155',
                'spread_home' => '-4.5 -110', 'spread_away' => '+4.5 -110',
                'total_over' => 'o217 -110', 'total_under' => 'u217 -110',
                'public_pct_home' => 86.7, 'public_pct_away' => 13.3,
                'money_pct_home' => 78.5, 'money_pct_away' => 21.5,
                'venue' => 'TD Garden, Boston, MA', 'broadcast' => 'TNT',
            ],
            [
                'sport' => 'Basketball', 'league' => 'NBA',
                'home_team' => 'Miami Heat', 'away_team' => 'Toronto Raptors',
                'game_date' => now()->addHours(44),
                'moneyline_home' => '-335', 'moneyline_away' => '+275',
                'spread_home' => '-7.5 -110', 'spread_away' => '+7.5 -110',
                'total_over' => 'o215 -110', 'total_under' => 'u215 -110',
                'public_pct_home' => 62, 'public_pct_away' => 38,
                'money_pct_home' => 58, 'money_pct_away' => 42,
                'venue' => 'Kaseya Center, Miami, FL', 'broadcast' => 'NBA League Pass',
            ],
            [
                'sport' => 'Football', 'league' => 'NFL',
                'home_team' => 'Dallas Cowboys', 'away_team' => 'Indianapolis Colts',
                'game_date' => now()->addDays(3),
                'moneyline_home' => '-450', 'moneyline_away' => '+350',
                'spread_home' => '-10.5 -110', 'spread_away' => '+10.5 -110',
                'total_over' => 'o43.5 -110', 'total_under' => 'u43.5 -110',
                'public_pct_home' => 93, 'public_pct_away' => 7,
                'money_pct_home' => 90, 'money_pct_away' => 10,
                'venue' => 'AT&T Stadium, Arlington, TX', 'broadcast' => 'NBC',
            ],
            [
                'sport' => 'Football', 'league' => 'NFL',
                'home_team' => 'Tampa Bay Buccaneers', 'away_team' => 'New Orleans Saints',
                'game_date' => now()->addDays(4),
                'moneyline_home' => '-200', 'moneyline_away' => '+170',
                'spread_home' => '-4 -110', 'spread_away' => '+4 -110',
                'total_over' => 'o40.5 -110', 'total_under' => 'u40.5 -110',
                'public_pct_home' => 63, 'public_pct_away' => 37,
                'money_pct_home' => 49, 'money_pct_away' => 51,
                'venue' => 'Raymond James Stadium, Tampa, FL', 'broadcast' => 'ESPN',
            ],
        ];

        foreach ($games as $game) {
            BettingConsensus::create($game);
        }

        BettingConsensus::factory(8)->create();
    }
}
