<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Storage::fake('public');
    }

    public function test_admin_can_view_projects_index()
    {
        $project = Project::factory()->create([
            'title' => 'Test Project',
            'status' => 'published'
        ]);

        $response = $this->actingAs($this->user)->get('/admin/projects');

        $response->assertStatus(200);
        $response->assertViewIs('admin.projects.index');
        $response->assertSee('Projects Management');
        $response->assertSee('Test Project');
        $response->assertSee('Create New Project');
    }

    public function test_admin_can_view_project_create_form()
    {
        $response = $this->actingAs($this->user)->get('/admin/projects/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.projects.create');
        $response->assertSee('Create New Project');
        $response->assertSee('Title');
        $response->assertSee('Description');
        $response->assertSee('Technologies');
        $response->assertSee('Tags');
    }

    public function test_admin_can_create_project_with_valid_data()
    {
        $thumbnail = UploadedFile::fake()->image('thumbnail.jpg');
        
        $projectData = [
            'title' => 'New Test Project',
            'description' => 'This is a test project description',
            'content' => 'This is the full project content',
            'thumbnail' => $thumbnail,
            'technologies' => ['Laravel', 'Vue.js'],
            'tags' => ['web', 'fullstack'],
            'project_url' => 'https://example.com',
            'github_url' => 'https://github.com/user/repo',
            'is_featured' => true,
            'status' => 'published'
        ];

        $response = $this->actingAs($this->user)->post('/admin/projects', $projectData);

        $response->assertRedirect('/admin/projects');
        $response->assertSessionHas('success', 'Project created successfully');

        $this->assertDatabaseHas('projects', [
            'title' => 'New Test Project',
            'slug' => 'new-test-project',
            'description' => 'This is a test project description',
            'status' => 'published',
            'is_featured' => true
        ]);

        Storage::disk('public')->assertExists('images/projects/' . $thumbnail->hashName());
    }

    public function test_admin_cannot_create_project_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->post('/admin/projects', []);

        $response->assertSessionHasErrors(['title', 'description']);
    }

    public function test_admin_can_view_project_edit_form()
    {
        $project = Project::factory()->create([
            'title' => 'Editable Project',
            'description' => 'Original description'
        ]);

        $response = $this->actingAs($this->user)->get("/admin/projects/{$project->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.projects.edit');
        $response->assertSee('Edit Project');
        $response->assertSee('Editable Project');
        $response->assertSee('Original description');
    }

    public function test_admin_can_update_project()
    {
        $project = Project::factory()->create([
            'title' => 'Original Title',
            'description' => 'Original description'
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'content' => 'Updated content',
            'technologies' => ['Laravel', 'React'],
            'tags' => ['web', 'updated'],
            'status' => 'draft'
        ];

        $response = $this->actingAs($this->user)->put("/admin/projects/{$project->id}", $updateData);

        $response->assertRedirect('/admin/projects');
        $response->assertSessionHas('success', 'Project updated successfully');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'status' => 'draft'
        ]);
    }

    public function test_admin_can_delete_project()
    {
        $project = Project::factory()->create([
            'title' => 'Project to Delete'
        ]);

        $response = $this->actingAs($this->user)->delete("/admin/projects/{$project->id}");

        $response->assertRedirect('/admin/projects');
        $response->assertSessionHas('success', 'Project deleted successfully');

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id
        ]);
    }

    public function test_admin_can_toggle_project_featured_status()
    {
        $project = Project::factory()->create([
            'is_featured' => false
        ]);

        $response = $this->actingAs($this->user)->patch("/admin/projects/{$project->id}/toggle-featured");

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Project featured status updated');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'is_featured' => true
        ]);
    }

    public function test_admin_can_bulk_delete_projects()
    {
        $project1 = Project::factory()->create();
        $project2 = Project::factory()->create();
        $project3 = Project::factory()->create();

        $response = $this->actingAs($this->user)->delete('/admin/projects/bulk-delete', [
            'project_ids' => [$project1->id, $project2->id]
        ]);

        $response->assertRedirect('/admin/projects');
        $response->assertSessionHas('success', '2 projects deleted successfully');

        $this->assertDatabaseMissing('projects', ['id' => $project1->id]);
        $this->assertDatabaseMissing('projects', ['id' => $project2->id]);
        $this->assertDatabaseHas('projects', ['id' => $project3->id]);
    }

    public function test_admin_can_search_projects()
    {
        Project::factory()->create(['title' => 'Laravel Project']);
        Project::factory()->create(['title' => 'Vue.js Project']);
        Project::factory()->create(['title' => 'React Application']);

        $response = $this->actingAs($this->user)->get('/admin/projects?search=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel Project');
        $response->assertDontSee('Vue.js Project');
        $response->assertDontSee('React Application');
    }

    public function test_admin_can_filter_projects_by_status()
    {
        Project::factory()->create(['title' => 'Published Project', 'status' => 'published']);
        Project::factory()->create(['title' => 'Draft Project', 'status' => 'draft']);

        $response = $this->actingAs($this->user)->get('/admin/projects?status=published');

        $response->assertStatus(200);
        $response->assertSee('Published Project');
        $response->assertDontSee('Draft Project');
    }

    public function test_admin_can_filter_projects_by_featured_status()
    {
        Project::factory()->create(['title' => 'Featured Project', 'is_featured' => true]);
        Project::factory()->create(['title' => 'Regular Project', 'is_featured' => false]);

        $response = $this->actingAs($this->user)->get('/admin/projects?featured=1');

        $response->assertStatus(200);
        $response->assertSee('Featured Project');
        $response->assertDontSee('Regular Project');
    }

    public function test_admin_can_update_project_sort_order()
    {
        $project1 = Project::factory()->create(['sort_order' => 1]);
        $project2 = Project::factory()->create(['sort_order' => 2]);

        $response = $this->actingAs($this->user)->patch('/admin/projects/reorder', [
            'projects' => [
                ['id' => $project1->id, 'sort_order' => 2],
                ['id' => $project2->id, 'sort_order' => 1]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('projects', ['id' => $project1->id, 'sort_order' => 2]);
        $this->assertDatabaseHas('projects', ['id' => $project2->id, 'sort_order' => 1]);
    }

    public function test_project_slug_is_automatically_generated()
    {
        $projectData = [
            'title' => 'My Awesome Project!',
            'description' => 'Test description',
            'status' => 'published'
        ];

        $response = $this->actingAs($this->user)->post('/admin/projects', $projectData);

        $this->assertDatabaseHas('projects', [
            'title' => 'My Awesome Project!',
            'slug' => 'my-awesome-project'
        ]);
    }

    public function test_project_slug_is_unique()
    {
        Project::factory()->create(['slug' => 'test-project']);

        $projectData = [
            'title' => 'Test Project',
            'description' => 'Test description',
            'status' => 'published'
        ];

        $response = $this->actingAs($this->user)->post('/admin/projects', $projectData);

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
            'slug' => 'test-project-1'
        ]);
    }
}