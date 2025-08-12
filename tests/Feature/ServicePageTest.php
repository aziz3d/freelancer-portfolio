<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_page_loads_successfully()
    {
        $response = $this->get(route('services'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.services');
        $response->assertSee('Services');
        $response->assertSee('What I Offer');
    }

    public function test_services_page_displays_active_services()
    {
        $activeService = Service::factory()->create([
            'title' => 'Web Development',
            'description' => 'Full-stack web development services',
            'is_active' => true
        ]);

        $inactiveService = Service::factory()->create([
            'title' => 'Inactive Service',
            'description' => 'This service is not active',
            'is_active' => false
        ]);

        $response = $this->get(route('services'));

        $response->assertSee('Web Development');
        $response->assertSee('Full-stack web development services');
        $response->assertDontSee('Inactive Service');
    }

    public function test_services_page_displays_services_in_correct_order()
    {
        $service1 = Service::factory()->create([
            'title' => 'Service 1',
            'sort_order' => 2,
            'is_active' => true
        ]);

        $service2 = Service::factory()->create([
            'title' => 'Service 2',
            'sort_order' => 1,
            'is_active' => true
        ]);

        $service3 = Service::factory()->create([
            'title' => 'Service 3',
            'sort_order' => 3,
            'is_active' => true
        ]);

        $response = $this->get(route('services'));
        $services = $response->viewData('services');

        $this->assertEquals('Service 2', $services->first()->title);
        $this->assertEquals('Service 3', $services->last()->title);
    }

    public function test_services_page_displays_service_features()
    {
        $service = Service::factory()->create([
            'title' => 'Web Development',
            'features' => [
                'Responsive Design',
                'SEO Optimization',
                'Performance Optimization'
            ],
            'is_active' => true
        ]);

        $response = $this->get(route('services'));

        $response->assertSee('Responsive Design');
        $response->assertSee('SEO Optimization');
        $response->assertSee('Performance Optimization');
    }

    public function test_services_page_displays_service_icons()
    {
        $service = Service::factory()->create([
            'title' => '3D Modeling',
            'icon' => 'fas fa-cube',
            'is_active' => true
        ]);

        $response = $this->get(route('services'));

        $response->assertSee('fas fa-cube');
    }

    public function test_services_page_shows_specific_services()
    {
        $services = [
            'Web Development',
            '3D Modeling',
            'UI/UX Design',
            'Retopology',
            'Rigging',
            'Rendering'
        ];

        foreach ($services as $serviceTitle) {
            Service::factory()->create([
                'title' => $serviceTitle,
                'is_active' => true
            ]);
        }

        $response = $this->get(route('services'));

        foreach ($services as $serviceTitle) {
            $response->assertSee($serviceTitle);
        }
    }

    public function test_services_page_shows_no_services_message_when_empty()
    {
        $response = $this->get(route('services'));

        $response->assertSee('No services available at the moment');
    }

    public function test_services_page_has_proper_seo_meta_tags()
    {
        $response = $this->get(route('services'));

        $response->assertSee('<title>Services - Aziz Khan</title>', false);
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('content="Professional services offered by Aziz Khan"', false);
    }

    public function test_services_page_includes_contact_cta()
    {
        $response = $this->get(route('services'));

        $response->assertSee('Get In Touch');
        $response->assertSee('Ready to start your project?');
    }
}