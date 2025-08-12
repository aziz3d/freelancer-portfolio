<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_index_page_loads_successfully()
    {
        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.projects.index');
        $response->assertViewHas(['projects', 'technologies', 'tags']);
    }

    public function test_projects_index_displays_only_published_projects()
    {
        $publishedProject = Project::factory()->create([
            'title' => 'Published Project',
            'status' => 'published'
        ]);
        
        $draftProject = Project::factory()->create([
            'title' => 'Draft Project',
            'status' => 'draft'
        ]);

        $response = $this->get(route('projects.index'));

        $response->assertSee('Published Project');
        $response->assertDontSee('Draft Project');
    }

    public function test_projects_index_filters_by_technology()
    {
        Project::factory()->create([
            'title' => 'Laravel Project',
            'technologies' => ['Laravel', 'PHP'],
            'status' => 'published'
        ]);
        
        Project::factory()->create([
            'title' => 'Vue Project',
            'technologies' => ['Vue.js', 'JavaScript'],
            'status' => 'published'
        ]);

        $response = $this->get(route('projects.index', ['technology' => 'Laravel']));

        $response->assertSee('Laravel Project');
        $response->assertDontSee('Vue Project');
    }

    public function test_projects_index_filters_by_tag()
    {
        Project::factory()->create([
            'title' => 'Web Project',
            'tags' => ['web', 'frontend'],
            'status' => 'published'
        ]);
        
        Project::factory()->create([
            'title' => 'Mobile Project',
            'tags' => ['mobile', 'app'],
            'status' => 'published'
        ]);

        $response = $this->get(route('projects.index', ['tag' => 'web']));

        $response->assertSee('Web Project');
        $response->assertDontSee('Mobile Project');
    }

    public function test_projects_index_shows_no_projects_message_when_empty()
    {
        $response = $this->get(route('projects.index'));

        $response->assertSee('No projects found');
    }

    public function test_projects_index_shows_filter_options()
    {
        Project::factory()->create([
            'technologies' => ['Laravel', 'PHP'],
            'tags' => ['web', 'backend'],
            'status' => 'published'
        ]);

        $response = $this->get(route('projects.index'));

        $response->assertSee('Filter by Technology');
        $response->assertSee('Filter by Tag');
        $response->assertSee('Laravel');
        $response->assertSee('web');
    }

    public function test_project_show_page_loads_successfully_for_published_project()
    {
        $project = Project::factory()->create([
            'title' => 'Test Project',
            'slug' => 'test-project',
            'status' => 'published'
        ]);

        $response = $this->get(route('projects.show', $project));

        $response->assertStatus(200);
        $response->assertViewIs('pages.projects.show');
        $response->assertViewHas(['project', 'relatedProjects']);
        $response->assertSee('Test Project');
    }

    public function test_project_show_returns_404_for_draft_project()
    {
        $project = Project::factory()->create([
            'title' => 'Draft Project',
            'slug' => 'draft-project',
            'status' => 'draft'
        ]);

        $response = $this->get(route('projects.show', $project));

        $response->assertStatus(404);
    }

    public function test_project_show_returns_404_for_nonexistent_project()
    {
        $response = $this->get('/projects/nonexistent-project');

        $response->assertStatus(404);
    }

    public function test_project_show_displays_project_details()
    {
        $project = Project::factory()->create([
            'title' => 'Detailed Project',
            'description' => 'This is a detailed project description',
            'content' => 'This is the full project content',
            'technologies' => ['Laravel', 'Vue.js'],
            'tags' => ['web', 'fullstack'],
            'project_url' => 'https://example.com',
            'github_url' => 'https://github.com/user/repo',
            'status' => 'published'
        ]);

        $response = $this->get(route('projects.show', $project));

        $response->assertSee('Detailed Project');
        $response->assertSee('This is a detailed project description');
        $response->assertSee('This is the full project content');
        $response->assertSee('Laravel');
        $response->assertSee('Vue.js');
        $response->assertSee('web');
        $response->assertSee('fullstack');
        $response->assertSee('View Live Project');
        $response->assertSee('View on GitHub');
    }

    public function test_project_show_displays_related_projects()
    {
        $mainProject = Project::factory()->create([
            'title' => 'Main Project',
            'technologies' => ['Laravel', 'Vue.js'],
            'status' => 'published'
        ]);

        $relatedProject1 = Project::factory()->create([
            'title' => 'Related Project 1',
            'technologies' => ['Laravel', 'React'],
            'status' => 'published'
        ]);

        $relatedProject2 = Project::factory()->create([
            'title' => 'Related Project 2',
            'technologies' => ['Vue.js', 'Node.js'],
            'status' => 'published'
        ]);

        $unrelatedProject = Project::factory()->create([
            'title' => 'Unrelated Project',
            'technologies' => ['Python', 'Django'],
            'status' => 'published'
        ]);

        $response = $this->get(route('projects.show', $mainProject));

        $response->assertSee('Related Projects');
        $response->assertSee('Related Project 1');
        $response->assertSee('Related Project 2');
        $response->assertDontSee('Unrelated Project');
    }

    public function test_project_show_limits_related_projects_to_three()
    {
        $mainProject = Project::factory()->create([
            'title' => 'Main Project',
            'technologies' => ['Laravel'],
            'status' => 'published'
        ]);

        // Create 5 related projects
        for ($i = 1; $i <= 5; $i++) {
            Project::factory()->create([
                'title' => "Related Project {$i}",
                'technologies' => ['Laravel'],
                'status' => 'published',
                'sort_order' => $i
            ]);
        }

        $response = $this->get(route('projects.show', $mainProject));
        $viewData = $response->viewData('relatedProjects');

        $this->assertCount(3, $viewData);
    }

    public function test_project_show_excludes_current_project_from_related()
    {
        $project = Project::factory()->create([
            'title' => 'Current Project',
            'technologies' => ['Laravel'],
            'status' => 'published'
        ]);

        $response = $this->get(route('projects.show', $project));
        $viewData = $response->viewData('relatedProjects');

        $this->assertFalse($viewData->contains('id', $project->id));
    }

    public function test_projects_index_orders_projects_correctly()
    {
        $project1 = Project::factory()->create([
            'title' => 'Project 1',
            'sort_order' => 2,
            'status' => 'published',
            'created_at' => now()->subDays(2)
        ]);

        $project2 = Project::factory()->create([
            'title' => 'Project 2',
            'sort_order' => 1,
            'status' => 'published',
            'created_at' => now()->subDay()
        ]);

        $project3 = Project::factory()->create([
            'title' => 'Project 3',
            'sort_order' => 1,
            'status' => 'published',
            'created_at' => now()
        ]);

        $response = $this->get(route('projects.index'));
        $projects = $response->viewData('projects');

        $this->assertEquals('Project 3', $projects->first()->title);
        $this->assertEquals('Project 1', $projects->last()->title);
    }
}