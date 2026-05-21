<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupportTicketFactory extends Factory
{
    public function definition()
    {
        return [
            'source_system' => 'legacy',
            'external_id' => 'TKT-' . $this->faker->unique()->numberBetween(10000, 99999),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'subject' => $this->faker->sentence(5),
            'message' => $this->faker->paragraph(4),
            'status' => $this->faker->randomElement(['open', 'pending', 'resolved', 'closed']),
            'priority' => $this->faker->numberBetween(1, 5),
            'legacy_created_at' => $this->faker->dateTimeBetween('-1 year', '-1 month'),
            'legacy_updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
