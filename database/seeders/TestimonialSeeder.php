<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{

    public function run(): void
    {
        $featuredTestimonials = [
            [
                'name' => 'Maria',
                'role' => 'CTO',
                'company' => 'TechFlow Solutions',
                'content' => 'Aziz delivered an exceptional e-commerce platform that exceeded our expectations. His expertise in Laravel and Vue.js, combined with his attention to detail, resulted in a robust solution that handles our high-volume traffic seamlessly. The project was completed on time and within budget. I highly recommend Aziz for any complex web development project.',
                'avatar' => 'portfolio_30.jpg',
                'rating' => 5,
                'is_featured' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Jhony Depp',
                'role' => 'Creative Director',
                'company' => 'Pixel Studios',
                'content' => 'Working with Aziz on our 3D character design for a film project was a fantastic experience. His technical skills in 3ds Max and ZBrush are outstanding, but what really impressed me was his creative vision and ability to bring our concepts to life. The characters he created became the cornerstone of our mobile game\'s success.',
                'avatar' => 'portfolio_31.jpg',
                'rating' => 5,
                'is_featured' => true,
                'sort_order' => 2
            ]
    
        ];

        foreach ($featuredTestimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
