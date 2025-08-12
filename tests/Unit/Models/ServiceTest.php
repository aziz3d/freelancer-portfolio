<?php

namespace Tests\Unit\Models;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_has_fillable_attributes()
    {
        $fillable = [
            'title', 'description', 'icon', 'features', 'sort_order', 'is_active'
        ];

        $service = new Service();
        $this->assertEquals($fillable, $service->getFillable());
    }

    public function test_service_casts_attributes_correctly()
    {
        $service = Service::factory()->create([
            'features' => ['Feature 1', 'Feature 2'],
            'is_active' => true,
        ]);

        $this->assertIsArray($service->features);
        $this->assertIsBool($service->is_active);
    }

    public function test_active_scope_returns_only_active_services()
    {
        Service::factory()->create(['is_active' => true]);
        Service::factory()->create(['is_active' => false]);
        Service::factory()->create(['is_active' => true]);

        $activeServices = Service::active()->get();

        $this->assertCount(2, $activeServices);
        $this->assertTrue($activeServices->every(fn($service) => $service->is_active));
    }

    public function test_ordered_scope_orders_services_by_sort_order()
    {
        $service1 = Service::factory()->create(['sort_order' => 3]);
        $service2 = Service::factory()->create(['sort_order' => 1]);
        $service3 = Service::factory()->create(['sort_order' => 2]);

        $orderedServices = Service::ordered()->get();

        $this->assertEquals($service2->id, $orderedServices[0]->id);
        $this->assertEquals($service3->id, $orderedServices[1]->id);
        $this->assertEquals($service1->id, $orderedServices[2]->id);
    }

    public function test_service_can_store_multiple_features()
    {
        $features = ['Web Development', '3D Modeling', 'UI/UX Design'];
        
        $service = Service::create([
            'title' => 'Test Service',
            'description' => 'Test description',
            'features' => $features,
            'is_active' => true
        ]);

        $this->assertEquals($features, $service->features);
        $this->assertCount(3, $service->features);
    }

    public function test_service_defaults_to_active()
    {
        $service = Service::factory()->create();
        
        $this->assertTrue($service->is_active);
    }

    public function test_service_can_have_icon()
    {
        $service = Service::create([
            'title' => 'Web Development',
            'description' => 'Full-stack web development services',
            'icon' => 'fas fa-code',
            'is_active' => true
        ]);

        $this->assertEquals('fas fa-code', $service->icon);
    }

    public function test_service_sort_order_affects_ordering()
    {
        Service::factory()->create(['title' => 'Service A', 'sort_order' => 10]);
        Service::factory()->create(['title' => 'Service B', 'sort_order' => 5]);
        Service::factory()->create(['title' => 'Service C', 'sort_order' => 15]);

        $services = Service::ordered()->pluck('title')->toArray();

        $this->assertEquals(['Service B', 'Service A', 'Service C'], $services);
    }
}