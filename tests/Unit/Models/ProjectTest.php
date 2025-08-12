<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_has_fillable_attributes()
    {
        $fillable = [
            'title', 'slug', 'description', 'content', 'thumbnail',
            'images', 'tags', 'technologies', 'project_url',
            'github_url', 'is_featured', 'sort_order', 'status'
        ];

        $project = new Project();
        $this->assertEquals($fillable, $project->getFillable());
    }

    public function test_project_casts_attributes_correctly()
    {
        $project = Project::factory()->create([
            'images' => ['image1.jpg', 'image2.jpg'],
            'tags' => ['laravel', 'php'],
            'technologies' => ['Laravel', 'MySQL'],
            'is_featured' => true,
        ]);

        $this->assertIsArray($project->images);
        $this->assertIsArray($project->tags);
        $this->assertIsArray($project->technologies);
        $this->assertIsBool($project->is_featured);
        $this->assertIsInt($project->sort_order);
    }

    public function test_slug_is_generated_automatically_on_creation()
    {
        $project = Project::create([
            'title' => 'Test Project Title',
            'description' => 'Test description',
            'status' => 'published'
        ]);

        $this->assertEquals('test-project-title', $project->slug);
    }

    public function test_unique_slug_generation_when_duplicate_exists()
    {
        Project::create([
            'title' => 'Test Project',
            'description' => 'Test description',
            'status' => 'published'
        ]);

        $secondProject = Project::create([
            'title' => 'Test Project',
            'description' => 'Another test description',
            'status' => 'published'
        ]);

        $this->assertEquals('test-project', Project::first()->slug);
        $this->assertEquals('test-project-1', $secondProject->slug);
    }

    public function test_featured_scope_returns_only_featured_projects()
    {
        Project::factory()->create(['is_featured' => true]);
        Project::factory()->create(['is_featured' => false]);
        Project::factory()->create(['is_featured' => true]);

        $featuredProjects = Project::featured()->get();

        $this->assertCount(2, $featuredProjects);
        $this->assertTrue($featuredProjects->every(fn($project) => $project->is_featured));
    }

    public function test_published_scope_returns_only_published_projects()
    {
        Project::factory()->create(['status' => 'published']);
        Project::factory()->create(['status' => 'draft']);
        Project::factory()->create(['status' => 'published']);

        $publishedProjects = Project::published()->get();

        $this->assertCount(2, $publishedProjects);
        $this->assertTrue($publishedProjects->every(fn($project) => $project->status === 'published'));
    }

    public function test_draft_scope_returns_only_draft_projects()
    {
        Project::factory()->create(['status' => 'published']);
        Project::factory()->create(['status' => 'draft']);
        Project::factory()->create(['status' => 'draft']);

        $draftProjects = Project::draft()->get();

        $this->assertCount(2, $draftProjects);
        $this->assertTrue($draftProjects->every(fn($project) => $project->status === 'draft'));
    }

    public function test_ordered_scope_orders_by_sort_order_then_created_at()
    {
        $project1 = Project::factory()->create(['sort_order' => 2, 'created_at' => now()->subDays(2)]);
        $project2 = Project::factory()->create(['sort_order' => 1, 'created_at' => now()->subDay()]);
        $project3 = Project::factory()->create(['sort_order' => 1, 'created_at' => now()]);

        $testProjectIds = [$project1->id, $project2->id, $project3->id];
        $orderedProjects = Project::ordered()->whereIn('id', $testProjectIds)->get();

        $this->assertCount(3, $orderedProjects);
        
        $sortOrders = $orderedProjects->pluck('sort_order')->toArray();
        $this->assertEquals([1, 1, 2], $sortOrders);
        
        $project1Items = $orderedProjects->where('sort_order', 1);
        $this->assertTrue($project1Items->first()->created_at->gte($project1Items->last()->created_at));
    }

    public function test_by_tag_scope_filters_projects_by_tag()
    {
        Project::factory()->create(['tags' => ['laravel', 'php']]);
        Project::factory()->create(['tags' => ['vue', 'javascript']]);
        Project::factory()->create(['tags' => ['laravel', 'vue']]);

        $laravelProjects = Project::byTag('laravel')->get();
        $vueProjects = Project::byTag('vue')->get();

        $this->assertCount(2, $laravelProjects);
        $this->assertCount(2, $vueProjects);
    }

    public function test_by_technology_scope_filters_projects_by_technology()
    {
        Project::factory()->create(['technologies' => ['Laravel', 'MySQL']]);
        Project::factory()->create(['technologies' => ['Vue.js', 'Node.js']]);
        Project::factory()->create(['technologies' => ['Laravel', 'Vue.js']]);

        $laravelProjects = Project::byTechnology('Laravel')->get();
        $vueProjects = Project::byTechnology('Vue.js')->get();

        $this->assertCount(2, $laravelProjects);
        $this->assertCount(2, $vueProjects);
    }

    public function test_featured_published_scope_returns_featured_published_projects_with_limit()
    {
        Project::factory()->create(['is_featured' => true, 'status' => 'published', 'sort_order' => 1]);
        Project::factory()->create(['is_featured' => true, 'status' => 'draft', 'sort_order' => 2]);
        Project::factory()->create(['is_featured' => false, 'status' => 'published', 'sort_order' => 3]);
        Project::factory()->create(['is_featured' => true, 'status' => 'published', 'sort_order' => 4]);

        $featuredPublished = Project::featuredPublished(1)->get();

        $this->assertCount(1, $featuredPublished);
        $this->assertTrue($featuredPublished->first()->is_featured);
        $this->assertEquals('published', $featuredPublished->first()->status);
    }

    public function test_is_published_method_returns_correct_boolean()
    {
        $publishedProject = Project::factory()->create(['status' => 'published']);
        $draftProject = Project::factory()->create(['status' => 'draft']);

        $this->assertTrue($publishedProject->isPublished());
        $this->assertFalse($draftProject->isPublished());
    }

    public function test_is_draft_method_returns_correct_boolean()
    {
        $publishedProject = Project::factory()->create(['status' => 'published']);
        $draftProject = Project::factory()->create(['status' => 'draft']);

        $this->assertFalse($publishedProject->isDraft());
        $this->assertTrue($draftProject->isDraft());
    }

    public function test_is_featured_method_returns_correct_boolean()
    {
        $featuredProject = Project::factory()->create(['is_featured' => true]);
        $regularProject = Project::factory()->create(['is_featured' => false]);

        $this->assertTrue($featuredProject->isFeatured());
        $this->assertFalse($regularProject->isFeatured());
    }

    public function test_route_key_name_is_slug()
    {
        $project = new Project();
        $this->assertEquals('slug', $project->getRouteKeyName());
    }
}