<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{

    public function run(): void
    {
        $realisticContacts = [
            [
                'name' => 'Alex Martinez',
                'email' => 'alex.martinez@techstartup.com',
                'subject' => 'Web Development Project Inquiry',
                'message' => 'Hi Aziz, I came across your portfolio and I\'m impressed with your Laravel and Vue.js work. We\'re a tech startup looking to build a SaaS platform for project management. Would you be available for a consultation call next week to discuss the project requirements and timeline?',
                'status' => 'new',
                'created_at' => now()->subDays(1)
            ]

    
        ];

        foreach ($realisticContacts as $contact) {
            Contact::create($contact);
        }

        Contact::factory()->count(8)->create(['status' => 'new']);
        Contact::factory()->count(6)->create(['status' => 'read']);
        Contact::factory()->count(4)->create(['status' => 'replied']);
    }
}
