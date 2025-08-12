<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = ['CEO', 'CTO', 'Project Manager', 'Lead Developer', 'Art Director', 'Creative Director', 'Senior Designer', 'Product Manager'];
        $companies = ['TechCorp', 'DesignStudio', 'GameDev Inc', 'Creative Agency', 'StartupXYZ', 'Digital Solutions', 'Innovation Labs', 'Media Group'];
        
        $avatarImages = [
            'portfolio_2.jpg', 'portfolio_3.jpg', 'portfolio_4.jpg', 'portfolio_5.jpg',
            'portfolio_6.jpg', 'portfolio_7.jpg', 'portfolio_8.jpg', 'portfolio_9.jpg',
            'portfolio_10.jpg', 'portfolio_11.jpg', 'portfolio_12.jpg', 'portfolio_13.jpg'
        ];
        
        return [
            'name' => fake()->name(),
            'role' => fake()->randomElement($roles),
            'company' => fake()->randomElement($companies),
            'content' => fake()->paragraph(3),
            'avatar' => fake()->randomElement($avatarImages),
            'rating' => fake()->numberBetween(4, 5),
            'is_featured' => fake()->boolean(25),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'rating' => 5,
        ]);
    }
}
