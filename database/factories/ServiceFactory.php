<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            [
                'title' => 'Web Development',
                'description' => 'Full-stack web development using modern technologies like Laravel, PHP, JavaScript, and Vue.js.',
                'icon' => 'code',
                'features' => ['Custom Web Applications', 'E-commerce Solutions', 'API Development', 'Database Design', 'Responsive Design']
            ],
            [
                'title' => '3D Modeling',
                'description' => 'Professional 3D modeling and visualization services for games, architecture, and product design.',
                'icon' => 'cube',
                'features' => ['Character Modeling', 'Environment Design', 'Product Visualization', 'Architectural Modeling', 'Game Assets']
            ],
            [
                'title' => 'UI/UX Design',
                'description' => 'User-centered design solutions that create intuitive and engaging digital experiences.',
                'icon' => 'design',
                'features' => ['User Interface Design', 'User Experience Research', 'Wireframing', 'Prototyping', 'Design Systems']
            ],
            [
                'title' => 'Retopology',
                'description' => 'Optimizing 3D models for better performance and animation-ready topology.',
                'icon' => 'mesh',
                'features' => ['Mesh Optimization', 'Animation-Ready Topology', 'LOD Creation', 'UV Mapping', 'Texture Optimization']
            ],
            [
                'title' => 'Rigging',
                'description' => 'Creating skeletal systems and controls for 3D character and object animation.',
                'icon' => 'skeleton',
                'features' => ['Character Rigging', 'Facial Rigging', 'Custom Controls', 'Constraint Systems', 'Animation Tools']
            ],
            [
                'title' => 'Rendering',
                'description' => 'High-quality rendering and visualization services for presentations and marketing.',
                'icon' => 'camera',
                'features' => ['Photorealistic Rendering', 'Lighting Setup', 'Material Creation', 'Post-Processing', 'Animation Rendering']
            ]
        ];

        $service = fake()->randomElement($services);
        
        return [
            'title' => $service['title'],
            'description' => $service['description'],
            'icon' => $service['icon'],
            'features' => $service['features'],
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active' => fake()->boolean(90),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }
}
