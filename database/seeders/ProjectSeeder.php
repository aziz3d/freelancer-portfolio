<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{

    public function run(): void
    {
        $featuredProjects = [
            [
                'title' => 'E-Commerce Platform with Laravel & Vue.js',
                'slug' => 'ecommerce-platform-laravel-vue',
                'description' => 'A comprehensive e-commerce solution built with Laravel backend and Vue.js frontend, featuring advanced product management, payment integration, and real-time inventory tracking.',
                'content' => 'This full-stack e-commerce platform represents a complete solution for modern online retail businesses. Built with Laravel 11 as the backend API and Vue.js 3 for the frontend, it incorporates advanced features like real-time inventory management, multi-payment gateway integration, and sophisticated user role management.

Key technical achievements include implementing a microservices architecture for scalability, integrating Stripe and PayPal payment systems, and developing a custom admin dashboard with real-time analytics. The platform handles over 10,000 products with advanced filtering and search capabilities powered by Elasticsearch.

The frontend utilizes Vue.js 3 with Composition API, Pinia for state management, and Tailwind CSS for responsive design. Performance optimizations include lazy loading, image optimization, and caching strategies that achieve 95+ PageSpeed scores.',
                'thumbnail' => 'portfolio_2.jpg',
                'images' => [
                    'portfolio_2.jpg',
                    'portfolio_3.jpg',
                    'portfolio_4.jpg',
                    'portfolio_5.jpg'
                ],
                'tags' => ['Web Development', 'Full Stack', 'E-commerce', 'API Development'],
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'Elasticsearch', 'Stripe API', 'Tailwind CSS'],
                'project_url' => 'https://demo-ecommerce.example.com',
                'github_url' => 'https://github.com/azizkhan/ecommerce-platform',
                'is_featured' => true,
                'sort_order' => 1,
                'status' => 'published'
            ],
            [
                'title' => '3D Character Design for Mobile Game',
                'slug' => '3d-character-design-mobile-game',
                'description' => 'Complete character pipeline from concept to game-ready assets for a fantasy mobile RPG, including modeling, texturing, rigging, and animation.',
                'content' => 'This project involved creating a complete set of fantasy characters for a mobile RPG game. The workflow encompassed the entire 3D character pipeline from initial concept sketches to final game-ready assets optimized for mobile platforms.

The character design process began with extensive concept art and reference gathering, followed by high-poly sculpting in ZBrush for detailed anatomy and costume elements. The models were then retopologized in 3ds Max to create clean, animation-friendly geometry suitable for mobile rendering constraints.

Texturing was accomplished using Substance Painter with a focus on stylized, hand-painted aesthetics that would appeal to the target demographic while maintaining optimal texture memory usage. The final characters feature modular armor systems and facial blend shapes for emotional expression during gameplay.

Each character was rigged with a custom control system in 3ds Max, featuring FK/IK switching, facial controls, and optimized bone counts for mobile performance. The final deliverables included idle, walk, run, attack, and death animations exported as FBX files.',
                'thumbnail' => 'portfolio_6.jpg',
                'images' => [
                    'portfolio_6.jpg',
                    'portfolio_7.jpg',
                    'portfolio_8.jpg',
                    'portfolio_9.jpg'
                ],
                'tags' => ['3D Modeling', 'Character Design', 'Game Development', 'Animation'],
                'technologies' => ['3ds Max', 'ZBrush', 'Substance Painter', 'Photoshop', 'Unity'],
                'project_url' => 'https://artstation.com/artwork/character-design',
                'github_url' => null,
                'is_featured' => true,
                'sort_order' => 2,
                'status' => 'published'
            ],
            [
                'title' => 'Real Estate Management System',
                'slug' => 'real-estate-management-system',
                'description' => 'Comprehensive property management platform with advanced search, virtual tours, and CRM integration for real estate agencies.',
                'content' => 'A sophisticated real estate management system designed to streamline property listings, client management, and sales processes for real estate agencies. The platform combines powerful backend functionality with an intuitive user interface.

The system features advanced property search with geolocation, price range filtering, and amenity-based queries. Integration with Google Maps API provides interactive property locations and neighborhood information. Virtual tour functionality allows 360-degree property viewing directly within the platform.

The CRM component tracks lead generation, client communications, and sales pipeline management. Automated email campaigns and appointment scheduling reduce administrative overhead while improving client engagement. The platform also includes financial reporting and commission tracking for agency management.

Built with Laravel for robust backend functionality and React for dynamic frontend interactions, the system handles high-volume property data with optimized database queries and caching strategies.',
                'thumbnail' => 'portfolio_10.jpg',
                'images' => [
                    'portfolio_10.jpg',
                    'portfolio_11.jpg',
                    'portfolio_12.jpg'
                ],
                'tags' => ['Web Development', 'CRM', 'Real Estate', 'Full Stack'],
                'technologies' => ['Laravel', 'React', 'PostgreSQL', 'Google Maps API', 'AWS S3'],
                'project_url' => 'https://realestate-demo.example.com',
                'github_url' => 'https://github.com/azizkhan/real-estate-system',
                'is_featured' => true,
                'sort_order' => 3,
                'status' => 'published'
            ],
            [
                'title' => 'Architectural Visualization Project',
                'slug' => 'architectural-visualization-project',
                'description' => 'Photorealistic 3D renderings and walkthrough animations for a luxury residential complex, showcasing interior and exterior designs.',
                'content' => 'This architectural visualization project involved creating stunning photorealistic renderings and animated walkthroughs for a high-end residential development. The project required meticulous attention to detail in modeling, lighting, and material creation.

The 3D modeling phase involved recreating the architectural plans with precise measurements and proportions using 3ds Max. Every architectural element was modeled with attention to real-world construction details, from window frames to decorative moldings.

Lighting setup utilized advanced global illumination techniques with V-Ray renderer to achieve photorealistic results. Multiple lighting scenarios were created to showcase the properties during different times of day, highlighting the natural light flow and artificial lighting design.

Material creation focused on achieving realistic surface properties for various architectural elements including marble, wood, glass, and metal finishes. Substance Designer was used to create custom procedural materials that could be easily adjusted for different design variations.

The final deliverables included high-resolution still renderings for marketing materials and smooth animated walkthroughs that allow potential buyers to experience the spaces virtually.',
                'thumbnail' => 'portfolio_13.jpg',
                'images' => [
                    'portfolio_13.jpg',
                    'portfolio_14.jpg',
                    'portfolio_15.jpg',
                    'portfolio_16.jpg'
                ],
                'tags' => ['3D Modeling', 'Architectural Visualization', 'Rendering', 'Animation'],
                'technologies' => ['3ds Max', 'V-Ray', 'Substance Designer', 'Photoshop', 'After Effects'],
                'project_url' => 'https://artstation.com/artwork/architectural-viz',
                'github_url' => null,
                'is_featured' => true,
                'sort_order' => 4,
                'status' => 'published'
            ],
            [
                'title' => 'Task Management SaaS Application',
                'slug' => 'task-management-saas-application',
                'description' => 'Multi-tenant SaaS platform for project and task management with team collaboration, time tracking, and advanced reporting features.',
                'content' => 'A comprehensive SaaS application designed for project and task management with multi-tenant architecture supporting unlimited organizations and users. The platform emphasizes team collaboration and productivity tracking.

The application features a sophisticated permission system with role-based access control, allowing organizations to customize user permissions at granular levels. Real-time collaboration is enabled through WebSocket integration, providing instant updates on task changes and team communications.

Advanced reporting capabilities include time tracking analytics, productivity metrics, and project profitability analysis. The dashboard provides customizable widgets and data visualization using Chart.js for actionable insights.

The technical architecture utilizes Laravel for the backend API with multi-tenancy support, Vue.js for the frontend SPA, and Redis for caching and session management. The application is deployed on AWS with auto-scaling capabilities to handle varying loads.',
                'thumbnail' => 'portfolio_17.jpg',
                'images' => [
                    'portfolio_17.jpg',
                    'portfolio_18.jpg',
                    'portfolio_19.jpg'
                ],
                'tags' => ['Web Development', 'SaaS', 'Project Management', 'Full Stack'],
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'WebSockets', 'AWS', 'Chart.js'],
                'project_url' => 'https://taskmanager-saas.example.com',
                'github_url' => 'https://github.com/azizkhan/task-management-saas',
                'is_featured' => true,
                'sort_order' => 5,
                'status' => 'published'
            ],
            [
                'title' => 'Product Visualization & Animation',
                'slug' => 'product-visualization-animation',
                'description' => 'High-end product visualization and promotional animations for consumer electronics, featuring detailed modeling and studio lighting.',
                'content' => 'This project focused on creating premium product visualizations and promotional animations for a consumer electronics brand. The work required exceptional attention to detail in modeling, materials, and lighting to achieve commercial-quality results.

The modeling process involved precise recreation of product specifications with accurate proportions and surface details. Every component was modeled separately to allow for exploded views and assembly animations. Special attention was paid to small details like screws, ports, and surface textures.

Material creation utilized physically-based rendering principles to achieve realistic surface properties. Custom shaders were developed for unique materials like brushed aluminum, glossy plastics, and LED displays. The materials were designed to respond accurately to different lighting conditions.

Studio lighting setups were created to match professional photography standards, allowing for consistent branding across all marketing materials. Multiple lighting scenarios were developed for different presentation needs, from technical documentation to lifestyle marketing.

The final animations showcase product features through smooth camera movements, component breakdowns, and interactive demonstrations that effectively communicate the product\'s value proposition.',
                'thumbnail' => 'portfolio_20.jpg',
                'images' => [
                    'portfolio_20.jpg',
                    'portfolio_21.jpg',
                    'portfolio_22.jpg',
                    'portfolio_23.jpg'
                ],
                'tags' => ['3D Modeling', 'Product Visualization', 'Animation', 'Rendering'],
                'technologies' => ['3ds Max', 'V-Ray', 'Substance Painter', 'After Effects', 'Photoshop'],
                'project_url' => 'https://artstation.com/artwork/product-viz',
                'github_url' => null,
                'is_featured' => true,
                'sort_order' => 6,
                'status' => 'published'
            ]
        ];

        foreach ($featuredProjects as $project) {
            Project::create($project);
        }

        Project::factory()
            ->count(12)
            ->published()
            ->create();

        Project::factory()
            ->count(4)
            ->create(['status' => 'draft']);
    }
}
