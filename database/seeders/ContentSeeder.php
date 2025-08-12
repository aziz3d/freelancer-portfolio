<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{

    public function run(): void
    {
        $contents = [
            [
                'key' => 'hero_title',
                'title' => 'Hero Title',
                'content' => 'Aziz Khan',
                'meta' => ['subtitle' => '2D/3D Artist & Web Developer']
            ],
            [
                'key' => 'hero_description',
                'title' => 'Hero Description',
                'content' => 'Passionate about creating stunning digital experiences through web development and 3D artistry. I combine technical expertise with creative vision to bring ideas to life.',
                'meta' => ['cta_primary' => 'View Projects', 'cta_secondary' => 'Hire Me']
            ],
            [
                'key' => 'about_summary',
                'title' => 'About Summary',
                'content' => 'I am a versatile 2D/3D Artist and Web Developer with over 5 years of experience in creating digital solutions. My expertise spans from full-stack web development using Laravel and modern JavaScript frameworks to professional 3D modeling and animation. I believe in the power of combining technical skills with creative vision to deliver exceptional results.',
                'meta' => [
                    'years_experience' => '5+',
                    'projects_completed' => '50+',
                    'happy_clients' => '30+'
                ]
            ],
            [
                'key' => 'skills_technical',
                'title' => 'Technical Skills',
                'content' => 'Technical expertise and programming languages',
                'meta' => [
                    'skills' => ['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React', 'MySQL', 'PostgreSQL', 'Git', 'Docker', 'AWS']
                ]
            ],
            [
                'key' => 'skills_creative',
                'title' => 'Creative Skills',
                'content' => 'Creative tools and design software',
                'meta' => [
                    'skills' => ['3ds Max', 'Blender', 'Maya', 'Photoshop', 'After Effects', 'Figma', 'Illustrator', 'Substance Painter', 'ZBrush', 'Cinema 4D']
                ]
            ],
            [
                'key' => 'contact_info',
                'title' => 'Contact Information',
                'content' => 'Get in touch for collaborations and opportunities',
                'meta' => [
                    'email' => 'aziz@example.com',
                    'phone' => '+1 (555) 123-4567',
                    'location' => 'New York, NY',
                    'social' => [
                        'linkedin' => 'https://linkedin.com/in/azizkhan',
                        'github' => 'https://github.com/azizkhan',
                        'artstation' => 'https://artstation.com/azizkhan'
                    ]
                ]
            ],
            [
                'key' => 'services_cta',
                'title' => 'Ready to Start Your Project?',
                'content' => "Let's discuss how I can help bring your vision to life with professional, high-quality work tailored to your specific needs.",
                'meta' => [
                    'primary_button_text' => 'Get In Touch',
                    'primary_button_url' => '/contact',
                    'secondary_button_text' => 'View My Work',
                    'secondary_button_url' => '/projects'
                ]
            ]
        ];

        foreach ($contents as $content) {
            Content::create($content);
        }
    }
}
