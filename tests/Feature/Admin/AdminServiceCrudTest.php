<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminServiceCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_admin_can_view_services_index()
    {
        $service = Service::factory()->create([
            'title' => 'Web Development',
            'is_active' => true
        ]);

        $response = $this->actingAs($this->user)->get('/admin/services');

        $response->assertStatus(200);
        $response->assertViewIs('admin.services.index');
        $response->assertSee('Services Management');
        $response->assertSee('Web Development');
        $response->assertSee('Create New Service');
    }

    public function test_admin_can_view_service_create_form()
    {
        $response = $this->actingAs($this->user)->get('/admin/services/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.services.create');
        $response->assertSee('Create New Service');
        $response->assertSee('Title');
        $response->assertSee('Description');
        $response->assertSee('Icon');
        $response->assertSee('Features');
    }

    public function test_admin_can_create_service_with_valid_data()
    {
        $serviceData = [
            'title' => 'Web Development',
            'description' => 'Full-stack web development services using modern technologies',
            'icon' => 'fas fa-code',
            'features' => [
                'Responsive Design',
                'SEO Optimization',
                'Performance Optimization',
                'Cross-browser Compatibility'
            ],
            'sort_order' => 1,
            'is_active' => true
        ];

        $response = $this->actingAs($this->user)->post('/admin/services', $serviceData);

        $response->assertRedirect('/admin/services');
        $response->assertSessionHas('success', 'Service created successfully');

        $this->assertDatabaseHas('services', [
            'title' => 'Web Development',
            'description' => 'Full-stack web development services using modern technologies',
            'icon' => 'fas fa-code',
            'is_active' => true
        ]);
    }

    public function test_admin_cannot_create_service_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->post('/admin/services', []);

        $response->assertSessionHasErrors(['title', 'description']);
    }

    public function test_admin_can_view_service_edit_form()
    {
        $service = Service::factory()->create([
            'title' => '3D Modeling',
            'description' => 'Professional 3D modeling services'
        ]);

        $response = $this->actingAs($this->user)->get("/admin/services/{$service->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.services.edit');
        $response->assertSee('Edit Service');
        $response->assertSee('3D Modeling');
        $response->assertSee('Professional 3D modeling services');
    }

    public function test_admin_can_update_service()
    {
        $service = Service::factory()->create([
            'title' => 'Original Service',
            'description' => 'Original description'
        ]);

        $updateData = [
            'title' => 'Updated Service',
            'description' => 'Updated description',
            'icon' => 'fas fa-updated',
            'features' => ['Updated Feature 1', 'Updated Feature 2'],
            'sort_order' => 5,
            'is_active' => false
        ];

        $response = $this->actingAs($this->user)->put("/admin/services/{$service->id}", $updateData);

        $response->assertRedirect('/admin/services');
        $response->assertSessionHas('success', 'Service updated successfully');

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title' => 'Updated Service',
            'description' => 'Updated description',
            'is_active' => false
        ]);
    }

    public function test_admin_can_delete_service()
    {
        $service = Service::factory()->create([
            'title' => 'Service to Delete'
        ]);

        $response = $this->actingAs($this->user)->delete("/admin/services/{$service->id}");

        $response->assertRedirect('/admin/services');
        $response->assertSessionHas('success', 'Service deleted successfully');

        $this->assertDatabaseMissing('services', [
            'id' => $service->id
        ]);
    }

    public function test_admin_can_toggle_service_active_status()
    {
        $service = Service::factory()->create([
            'is_active' => false
        ]);

        $response = $this->actingAs($this->user)->patch("/admin/services/{$service->id}/toggle-active");

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Service status updated');

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'is_active' => true
        ]);
    }

    public function test_admin_can_bulk_delete_services()
    {
        $service1 = Service::factory()->create();
        $service2 = Service::factory()->create();
        $service3 = Service::factory()->create();

        $response = $this->actingAs($this->user)->delete('/admin/services/bulk-delete', [
            'service_ids' => [$service1->id, $service2->id]
        ]);

        $response->assertRedirect('/admin/services');
        $response->assertSessionHas('success', '2 services deleted successfully');

        $this->assertDatabaseMissing('services', ['id' => $service1->id]);
        $this->assertDatabaseMissing('services', ['id' => $service2->id]);
        $this->assertDatabaseHas('services', ['id' => $service3->id]);
    }

    public function test_admin_can_reorder_services()
    {
        $service1 = Service::factory()->create(['sort_order' => 1]);
        $service2 = Service::factory()->create(['sort_order' => 2]);
        $service3 = Service::factory()->create(['sort_order' => 3]);

        $response = $this->actingAs($this->user)->patch('/admin/services/reorder', [
            'services' => [
                ['id' => $service3->id, 'sort_order' => 1],
                ['id' => $service1->id, 'sort_order' => 2],
                ['id' => $service2->id, 'sort_order' => 3]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('services', ['id' => $service3->id, 'sort_order' => 1]);
        $this->assertDatabaseHas('services', ['id' => $service1->id, 'sort_order' => 2]);
        $this->assertDatabaseHas('services', ['id' => $service2->id, 'sort_order' => 3]);
    }

    public function test_admin_can_search_services()
    {
        Service::factory()->create(['title' => 'Web Development']);
        Service::factory()->create(['title' => '3D Modeling']);
        Service::factory()->create(['title' => 'UI/UX Design']);

        $response = $this->actingAs($this->user)->get('/admin/services?search=Web');

        $response->assertStatus(200);
        $response->assertSee('Web Development');
        $response->assertDontSee('3D Modeling');
        $response->assertDontSee('UI/UX Design');
    }

    public function test_admin_can_filter_services_by_status()
    {
        Service::factory()->create(['title' => 'Active Service', 'is_active' => true]);
        Service::factory()->create(['title' => 'Inactive Service', 'is_active' => false]);

        $response = $this->actingAs($this->user)->get('/admin/services?status=active');

        $response->assertStatus(200);
        $response->assertSee('Active Service');
        $response->assertDontSee('Inactive Service');
    }

    public function test_admin_can_create_specific_required_services()
    {
        $requiredServices = [
            'Web Development',
            '3D Modeling',
            'UI/UX Design',
            'Retopology',
            'Rigging',
            'Rendering'
        ];

        foreach ($requiredServices as $serviceTitle) {
            $serviceData = [
                'title' => $serviceTitle,
                'description' => "Professional {$serviceTitle} services",
                'icon' => 'fas fa-service',
                'features' => ['Feature 1', 'Feature 2'],
                'is_active' => true
            ];

            $response = $this->actingAs($this->user)->post('/admin/services', $serviceData);
            $response->assertRedirect('/admin/services');
        }

        foreach ($requiredServices as $serviceTitle) {
            $this->assertDatabaseHas('services', [
                'title' => $serviceTitle,
                'is_active' => true
            ]);
        }
    }

    public function test_service_features_are_stored_as_array()
    {
        $serviceData = [
            'title' => 'Test Service',
            'description' => 'Test description',
            'features' => ['Feature 1', 'Feature 2', 'Feature 3']
        ];

        $response = $this->actingAs($this->user)->post('/admin/services', $serviceData);

        $service = Service::where('title', 'Test Service')->first();
        $this->assertIsArray($service->features);
        $this->assertCount(3, $service->features);
        $this->assertContains('Feature 1', $service->features);
    }

    public function test_admin_can_duplicate_service()
    {
        $service = Service::factory()->create([
            'title' => 'Original Service',
            'description' => 'Original description',
            'features' => ['Feature 1', 'Feature 2']
        ]);

        $response = $this->actingAs($this->user)->post("/admin/services/{$service->id}/duplicate");

        $response->assertRedirect('/admin/services');
        $response->assertSessionHas('success', 'Service duplicated successfully');

        $this->assertDatabaseHas('services', [
            'title' => 'Original Service (Copy)',
            'description' => 'Original description'
        ]);
    }
}