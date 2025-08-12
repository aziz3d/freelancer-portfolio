<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6, false);
        $tags = ['Web Development', '3D Modeling', 'Laravel', 'PHP', 'JavaScript', 'Tutorial', 'Tips', 'Industry News', 'Portfolio', 'Design'];
        
        $blogImages = [
            'portfolio_2.jpg', 'portfolio_3.jpg', 'portfolio_4.jpg', 'portfolio_5.jpg',
            'portfolio_6.jpg', 'portfolio_7.jpg', 'portfolio_8.jpg', 'portfolio_9.jpg',
            'portfolio_10.jpg', 'portfolio_11.jpg', 'portfolio_12.jpg', 'portfolio_13.jpg',
            'portfolio_14.jpg', 'portfolio_15.jpg', 'portfolio_16.jpg', 'portfolio_17.jpg'
        ];
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(1),
            'content' => fake()->paragraphs(8, true),
            'thumbnail' => fake()->randomElement($blogImages),
            'meta_title' => $title . ' | Aziz Khan Blog',
            'meta_description' => fake()->sentence(12),
            'tags' => fake()->randomElements($tags, fake()->numberBetween(2, 5)),
            'status' => fake()->randomElement(['draft', 'published']),
            'published_at' => fake()->optional(0.8)->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }


    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}
