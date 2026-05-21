<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->sentence(6);
        $sport = $this->faker->randomElement(['NFL', 'NBA', 'MLB', 'NHL', 'NCAA']);
        $category = $this->faker->randomElement(['analysis', 'consensus', 'trends', 'picks', 'news']);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->paragraph(2),
            'content' => $this->faker->paragraphs(6, true),
            'category' => $category,
            'sport' => $sport,
            'author' => 'Sam Profeta',
            'is_premium' => $this->faker->boolean(30),
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
        ];
    }
}
