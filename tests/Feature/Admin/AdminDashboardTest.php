<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Project;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_correct_statistics()
    {
        $user = User::factory()->create();

        Project::factory()->count(5)->create(['status' => 'published']);
        Project::factory()->count(3)->create(['status' => 'draft']);
        
        Blog::factory()->count(4)->create(['status' => 'published']);
        Blog::factory()->count(2)->create(['status' => 'draft']);
        
        Service::factory()->count(6)->create(['is_active' => true]);
        Service::factory()->count(1)->create(['is_active' => false]);
        
        Testimonial::factory()->count(3)->create(['is_featured' => true]);
        Testimonial::factory()->count(2)->create(['is_featured' => false]);
        
        Contact::factory()->count(4)->create(['status' => 'new']);
        Contact::factory()->count(2)->create(['status' => 'read']);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        
        $response->assertSee('8');
        $response->assertSee('5');
        $response->assertSee('6');
        $response->assertSee('4');
        $response->assertSee('7');
        $response->assertSee('6');
        $response->assertSee('6');
        $response->assertSee('4');
    }

    public function test_dashboard_displays_recent_activity()
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'This is a test message from John Doe',
            'status' => 'new'
        ]);

        $project = Project::factory()->create([
            'title' => 'Test Project',
            'description' => 'This is a test project description',
            'status' => 'published'
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Recent Messages');
        $response->assertSee('Recent Projects');
        $response->assertSee('John Doe');
        $response->assertSee('john@example.com');
        $response->assertSee('Test Project');
    }

    public function test_dashboard_displays_quick_actions()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Quick Actions');
        $response->assertSee('New Project');
        $response->assertSee('New Blog Post');
        $response->assertSee('Manage Services');
        $response->assertSee('Edit Content');
    }
}