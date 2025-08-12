<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $contentTypes = [
            [
                'key' => 'hero_title',
                'title' => 'Hero Title',
                'content' => 'Aziz Khan',
                'meta' => ['subtitle' => '2D/3D Artist & Web Developer']
            ],
            [
                'key' => 'hero_description',
                'title' => 'Hero Description',
                'content' => 'Passionate about creating stunning digital experiences through web development and 3D artistry.',
                'meta' => ['cta_primary' => 'View Projects', 'cta_secondary' => 'Hire Me']
            ],
            [
                'key' => 'about_summary',
                'title' => 'About Summary',
                'content' => fake()->paragraphs(3, true),
                'meta' => ['years_experience' => '5+', 'projects_completed' => '50+']
            ],
            [
                'key' => 'skills',
                'title' => 'Skills',
                'content' => 'Technical skills and expertise',
                'meta' => [
                    'technical' => ['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'MySQL'],
                    'creative' => ['3ds Max', 'Blender', 'Photoshop', 'After Effects', 'Figma']
                ]
            ]
        ];

        $content = fake()->randomElement($contentTypes);
        
        return [
            'key' => $content['key'],
            'title' => $content['title'],
            'content' => $content['content'],
            'meta' => $content['meta'],
        ];
    }
}
