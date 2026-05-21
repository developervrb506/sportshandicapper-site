<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContestFactory extends Factory
{
    public function definition()
    {
        $startsAt = $this->faker->dateTimeBetween('-30 days', '+60 days');
        $endsAt = (clone $startsAt)->modify('+' . $this->faker->numberBetween(7, 90) . ' days');
        return [
            'name' => $this->faker->catchPhrase(),
            'contest_type' => $this->faker->randomElement(['prediction', 'quiz', 'bracket', 'leaderboard']),
            'description' => $this->faker->paragraph(2),
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'status' => $this->faker->randomElement(['draft', 'active', 'paused', 'completed']),
        ];
    }
}
