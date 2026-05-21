<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TipFactory extends Factory
{
    public function definition()
    {
        $displayDate = $this->faker->dateTimeBetween('-30 days', '+30 days');
        return [
            'added_date' => $this->faker->dateTimeBetween('-90 days', '-1 day'),
            'tip_title' => $this->faker->sentence(4),
            'tip_text' => $this->faker->paragraph(3),
            'group_name' => $this->faker->randomElement(['Premier League', 'Champions League', 'La Liga', 'Serie A', 'Bundesliga']),
            'display_yearly' => $this->faker->boolean(20),
            'display_date' => $displayDate,
            'shown_date' => $this->faker->boolean(60) ? $displayDate : null,
            'display_day' => $this->faker->numberBetween(1, 7),
        ];
    }
}
