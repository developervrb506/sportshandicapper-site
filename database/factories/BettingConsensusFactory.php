<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BettingConsensusFactory extends Factory
{
    public function definition()
    {
        $league = $this->faker->randomElement(['NFL', 'NBA', 'MLB', 'NHL']);
        $homeTeam = $this->faker->randomElement(['Lakers', 'Celtics', 'Cowboys', 'Chiefs', 'Yankees', 'Bruins']);
        $awayTeam = $this->faker->randomElement(['Warriors', 'Heat', 'Eagles', 'Bills', 'Red Sox', 'Rangers']);
        $spread = $this->faker->numberBetween(1, 14);
        $total = $this->faker->numberBetween(180, 250);
        return [
            'sport' => 'Basketball',
            'league' => $league,
            'home_team' => $homeTeam,
            'away_team' => $awayTeam,
            'game_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'moneyline_home' => '-' . $this->faker->numberBetween(110, 350),
            'moneyline_away' => '+' . $this->faker->numberBetween(100, 300),
            'spread_home' => '-' . $spread . ' -110',
            'spread_away' => '+' . $spread . ' -110',
            'total_over' => 'o' . $total . ' -110',
            'total_under' => 'u' . $total . ' -110',
            'public_pct_home' => $this->faker->numberBetween(35, 85),
            'public_pct_away' => 0,
            'money_pct_home' => $this->faker->numberBetween(40, 80),
            'money_pct_away' => 0,
            'venue' => $this->faker->city() . ' Arena',
            'broadcast' => $this->faker->randomElement(['ESPN', 'TNT', 'NBA TV', 'NFL Network']),
        ];
    }
}
