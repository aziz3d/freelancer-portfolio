<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class AboutContentSeeder extends Seeder
{
    public function run(): void
    {
       
        Content::updateOrCreate(
            ['key' => 'about_profile_summary'],
            [
                'title' => 'My Story',
                'content' => 'Passionate 2D/3D Artist & Web Developer with expertise in creating digital experiences that blend creativity with technical excellence. I specialize in web development using modern frameworks like Laravel, and 3D modeling with industry-standard tools like 3ds Max and Blender. My journey combines artistic vision with technical precision to deliver exceptional results.',
                'meta' => [
                    'image' => '/images/about/profile.jpg',
                    'years_experience' => 5,
                    'projects_completed' => 50
                ]
            ]
        );

        
        Content::updateOrCreate(
            ['key' => 'about_skills'],
            [
                'title' => 'Skills & Technologies',
                'content' => 'Technical expertise across multiple domains',
                'meta' => [
                    'categories' => [
                        [
                            'name' => 'Web Development',
                            'skills' => [
                                ['name' => 'Laravel', 'level' => 90, 'icon' => 'laravel'],
                                ['name' => 'PHP', 'level' => 85, 'icon' => 'php'],
                                ['name' => 'JavaScript', 'level' => 80, 'icon' => 'javascript'],
                                ['name' => 'Vue.js', 'level' => 75, 'icon' => 'vue'],
                                ['name' => 'Tailwind CSS', 'level' => 90, 'icon' => 'tailwind']
                            ]
                        ],
                        [
                            'name' => '3D Modeling & Animation',
                            'skills' => [
                                ['name' => '3ds Max', 'level' => 95, 'icon' => '3dsmax'],
                                ['name' => 'Blender', 'level' => 80, 'icon' => 'blender'],
                                ['name' => 'Maya', 'level' => 70, 'icon' => 'maya'],
                                ['name' => 'ZBrush', 'level' => 75, 'icon' => 'zbrush'],
                                ['name' => 'Substance Painter', 'level' => 80, 'icon' => 'substance']
                            ]
                        ],
                        [
                            'name' => 'Design & UI/UX',
                            'skills' => [
                                ['name' => 'Figma', 'level' => 85, 'icon' => 'figma'],
                                ['name' => 'Adobe Photoshop', 'level' => 90, 'icon' => 'photoshop'],
                                ['name' => 'Adobe Illustrator', 'level' => 80, 'icon' => 'illustrator'],
                                ['name' => 'UI/UX Design', 'level' => 85, 'icon' => 'design'],
                                ['name' => 'Prototyping', 'level' => 80, 'icon' => 'prototype']
                            ]
                        ]
                    ]
                ]
            ]
        );

        
        Content::updateOrCreate(
            ['key' => 'about_experience'],
            [
                'title' => 'Work Experience',
                'content' => 'Professional journey and key achievements',
                'meta' => [
                    'timeline' => [
                        [
                            'position' => 'Senior 3D Artist & Web Developer',
                            'company' => 'Freelance',
                            'location' => 'Remote',
                            'period' => '2022 - Present',
                            'description' => 'Leading 3D modeling projects and developing custom web applications for clients worldwide. Specialized in architectural visualization and e-commerce platforms using Laravel and modern 3D tools.',
                            'achievements' => [
                                'Completed 25+ 3D visualization projects',
                                'Developed 10+ Laravel applications',
                                'Maintained 98% client satisfaction rate',
                                'Reduced project delivery time by 40% through workflow optimization'
                            ],
                            'technologies' => ['Laravel', '3ds Max', 'Vue.js', 'Tailwind CSS', 'Blender']
                        ],
                        [
                            'position' => '3D Modeler & Web Developer',
                            'company' => 'Digital Studio',
                            'location' => 'Karachi, Pakistan',
                            'period' => '2020 - 2022',
                            'description' => 'Created high-quality 3D models for games and architectural projects while developing web solutions for internal tools and client projects. Collaborated with cross-functional teams to deliver complex digital solutions.',
                            'achievements' => [
                                'Reduced modeling time by 30% through workflow optimization',
                                'Built internal project management system',
                                'Mentored 3 junior developers',
                                'Led team of 5 artists on major visualization project'
                            ],
                            'technologies' => ['3ds Max', 'PHP', 'MySQL', 'JavaScript', 'V-Ray']
                        ],
                        [
                            'position' => 'Junior 3D Artist',
                            'company' => 'Creative Agency',
                            'location' => 'Karachi, Pakistan',
                            'period' => '2019 - 2020',
                            'description' => 'Started career focusing on 3D modeling and animation for advertising campaigns and product visualizations. Gained expertise in industry-standard tools and workflows.',
                            'achievements' => [
                                'Created 3D assets for 15+ advertising campaigns',
                                'Learned advanced texturing and lighting techniques',
                                'Collaborated with design teams on creative projects',
                                'Completed professional certification in 3ds Max'
                            ],
                            'technologies' => ['3ds Max', 'V-Ray', 'Photoshop', 'After Effects']
                        ]
                    ]
                ]
            ]
        );
    }
}