<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{

    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'description' => 'Full-stack web development using modern technologies like Laravel, PHP, JavaScript, and Vue.js to create robust and scalable web applications.',
                'icon' => 'code',
                'features' => ['Custom Web Applications', 'E-commerce Solutions', 'API Development', 'Database Design', 'Responsive Design'],
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => '3D Modeling',
                'description' => 'Professional 3D modeling and visualization services for games, architecture, and product design using industry-standard tools.',
                'icon' => 'cube',
                'features' => ['Character Modeling', 'Environment Design', 'Product Visualization', 'Architectural Modeling', 'Game Assets'],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'UI/UX Design',
                'description' => 'User-centered design solutions that create intuitive and engaging digital experiences with focus on usability and aesthetics.',
                'icon' => 'design',
                'features' => ['User Interface Design', 'User Experience Research', 'Wireframing', 'Prototyping', 'Design Systems'],
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Retopology',
                'description' => 'Optimizing 3D models for better performance and creating animation-ready topology for games and film production.',
                'icon' => 'mesh',
                'features' => ['Mesh Optimization', 'Animation-Ready Topology', 'LOD Creation', 'UV Mapping', 'Texture Optimization'],
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Rigging',
                'description' => 'Creating skeletal systems and controls for 3D character and object animation with custom tools and constraints.',
                'icon' => 'skeleton',
                'features' => ['Character Rigging', 'Facial Rigging', 'Custom Controls', 'Constraint Systems', 'Animation Tools'],
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Rendering',
                'description' => 'High-quality rendering and visualization services for presentations, marketing materials, and final production output.',
                'icon' => 'camera',
                'features' => ['Photorealistic Rendering', 'Lighting Setup', 'Material Creation', 'Post-Processing', 'Animation Rendering'],
                'sort_order' => 6,
                'is_active' => true,
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
