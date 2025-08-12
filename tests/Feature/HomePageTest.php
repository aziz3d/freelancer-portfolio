<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Blog;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Aziz Khan');
        $response->assertSee('2D/3D Artist & Web Developer');
        $response->assertSee('View Projects');
        $response->assertSee('Hire Me');
    }

    public function test_homepage_displays_featured_projects()
    {
        $featuredProject = Project::factory()->create([
            'title' => 'Featured Test Project',
            'is_featured' => true,
            'status' => 'published'
        ]);

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Featured Test Project');
        $response->assertSee('Featured Work');
    }

    public function test_homepage_displays_recent_blogs()
    {
        $blog = Blog::factory()->create([
            'title' => 'Test Blog Post',
            'status' => 'published',
            'published_at' => now()
        ]);

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Test Blog Post');
        $response->assertSee('Latest Articles');
    }

    public function test_homepage_displays_testimonials()
    {
        $testimonial = Testimonial::factory()->create([
            'name' => 'John Doe',
            'content' => 'Great work by Aziz!',
            'is_featured' => true
        ]);

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Great work by Aziz!');
        $response->assertSee('What Clients Say');
    }

    public function test_homepage_shows_project_stats()
    {
        Project::factory()->count(5)->create(['status' => 'published']);

        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Projects Completed');
        $response->assertSee('Years Experience');
        $response->assertSee('Client Satisfaction');
    }
}