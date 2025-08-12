<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            'Project Inquiry',
            'Collaboration Opportunity',
            'Freelance Work',
            'Technical Question',
            'Portfolio Feedback',
            'Job Opportunity',
            'Partnership Proposal',
            'General Inquiry'
        ];
        
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'subject' => fake()->randomElement($subjects),
            'message' => fake()->paragraphs(2, true),
            'status' => fake()->randomElement(['new', 'read', 'replied']),
        ];
    }

    public function newStatus(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'new',
        ]);
    }
}
