<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{

    public function run(): void
    {
        $menus = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'route_name' => 'home',
                'icon' => 'home',
                'sort_order' => 1,
                'is_active' => true,
                'is_system' => true,
                'description' => 'Homepage of the website',
            ],
            [
                'title' => 'About',
                'slug' => 'about',
                'route_name' => 'about',
                'icon' => 'user',
                'sort_order' => 2,
                'is_active' => true,
                'is_system' => true,
                'description' => 'About page',
            ],
            [
                'title' => 'Projects',
                'slug' => 'projects',
                'route_name' => 'projects.index',
                'icon' => 'briefcase',
                'sort_order' => 3,
                'is_active' => true,
                'is_system' => true,
                'description' => 'Projects portfolio',
            ],
            [
                'title' => 'Blog',
                'slug' => 'blog',
                'route_name' => 'blog.index',
                'icon' => 'document-text',
                'sort_order' => 4,
                'is_active' => true,
                'is_system' => true,
                'description' => 'Blog articles',
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'route_name' => 'services',
                'icon' => 'cog',
                'sort_order' => 5,
                'is_active' => true,
                'is_system' => true,
                'description' => 'Services offered',
            ],
            [
                'title' => 'Testimonials',
                'slug' => 'testimonials',
                'route_name' => 'testimonials',
                'icon' => 'chat-bubble-left-right',
                'sort_order' => 6,
                'is_active' => true,
                'is_system' => true,
                'description' => 'Client testimonials',
            ],
            [
                'title' => 'Contact Me',
                'slug' => 'contact',
                'route_name' => 'contact',
                'icon' => 'envelope',
                'sort_order' => 7,
                'is_active' => true,
                'is_system' => true,
                'description' => 'Contact form',
            ],
        ];

        foreach ($menus as $menuData) {
            \App\Models\Menu::updateOrCreate(
                ['slug' => $menuData['slug']],
                $menuData
            );
        }
    }
}
