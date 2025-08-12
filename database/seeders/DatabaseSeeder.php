<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            AdminUserSeeder::class,
            ContentSeeder::class,
            ServiceSeeder::class,
            ProjectSeeder::class,
            BlogSeeder::class,
            TestimonialSeeder::class,
            ContactSeeder::class,
        ]);
    }
}
