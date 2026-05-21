<?php

namespace Database\Factories;

use App\Models\Pick;
use Illuminate\Database\Eloquent\Factories\Factory;

class PickFactory extends Factory
{
    protected $model = Pick::class;

    public function definition()
    {
        $sports = ['NFL', 'NCAAF', 'NBA', 'NCAAB', 'NHL', 'MLB'];
        $results = ['pending', 'win', 'loss', 'push'];
        $picks = ['Moneyline', 'Spread', 'Over', 'Under', 'Team Total'];

        $stars = $this->faker->randomElement([1, 2, 3, 4, 5]);
        $result = $this->faker->randomElement($results);
        $units = null;

        if ($result === 'win') {
            $units = $stars * 1.00;
        } elseif ($result === 'loss') {
            $units = $stars * -1.10;
        }

        return [
            'sport' => $this->faker->randomElement($sports),
            'game_date' => $this->faker->dateTimeBetween('-7 days', '+3 days'),
            'game_time' => $this->faker->time('H:i'),
            'team1_name' => $this->faker->company,
            'team1_rotation' => $this->faker->numberBetween(101, 999),
            'team2_name' => $this->faker->company,
            'team2_rotation' => $this->faker->numberBetween(101, 999),
            'venue' => $this->faker->city . ' Stadium',
            'pick' => $this->faker->randomElement($picks),
            'simulation_result' => null,
            'stars' => $stars,
            'result' => $result,
            'units' => $units,
            'expert_name' => $this->faker->randomElement(['Staff', 'Pro Capper', 'Whale Expert']),
            'is_active' => true,
            'is_whale_exclusive' => $stars === 10,
        ];
    }
}
