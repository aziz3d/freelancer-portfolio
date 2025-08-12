<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3, false);
        $technologies = ['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React', 'Tailwind CSS', '3ds Max', 'Blender', 'Photoshop', 'MySQL', 'PostgreSQL'];
        $tags = ['Web Development', '3D Modeling', 'UI/UX', 'Frontend', 'Backend', 'Full Stack', 'Animation', 'Rendering'];
        
        $portfolioImages = [
            'portfolio_2.jpg', 'portfolio_3.jpg', 'portfolio_4.jpg', 'portfolio_5.jpg',
            'portfolio_6.jpg', 'portfolio_7.jpg', 'portfolio_8.jpg', 'portfolio_9.jpg',
            'portfolio_10.jpg', 'portfolio_11.jpg', 'portfolio_12.jpg', 'portfolio_13.jpg',
            'portfolio_14.jpg', 'portfolio_15.jpg', 'portfolio_16.jpg', 'portfolio_17.jpg',
            'portfolio_18.jpg', 'portfolio_19.jpg', 'portfolio_20.jpg', 'portfolio_21.jpg',
            'portfolio_22.jpg', 'portfolio_23.jpg', 'portfolio_24.jpg', 'portfolio_25.jpg',
            'portfolio_27.jpg', 'portfolio_28.jpg', 'portfolio_29.jpg', 'portfolio_30.jpg',
            'portfolio_31.jpg', 'portfolio_32.jpg', 'portfolio_33.jpg', 'portfolio_34.jpg',
            'portfolio_35.jpg', 'portfolio_36.jpg'
        ];
        
        $selectedImages = fake()->randomElements($portfolioImages, fake()->numberBetween(3, 6));
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(2),
            'content' => fake()->paragraphs(5, true),
            'thumbnail' => $selectedImages[0],
            'images' => $selectedImages,
            'tags' => fake()->randomElements($tags, fake()->numberBetween(2, 4)),
            'technologies' => fake()->randomElements($technologies, fake()->numberBetween(3, 6)),
            'project_url' => fake()->optional(0.7)->url(),
            'github_url' => fake()->optional(0.8)->url(),
            'is_featured' => fake()->boolean(30),
            'sort_order' => fake()->numberBetween(0, 100),
            'status' => fake()->randomElement(['draft', 'published']),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'status' => 'published',
        ]);
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }
}
