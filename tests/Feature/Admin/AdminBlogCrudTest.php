<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBlogCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Storage::fake('public');
    }

    public function test_admin_can_view_blogs_index()
    {
        $blog = Blog::factory()->create([
            'title' => 'Test Blog Post',
            'status' => 'published'
        ]);

        $response = $this->actingAs($this->user)->get('/admin/blogs');

        $response->assertStatus(200);
        $response->assertViewIs('admin.blogs.index');
        $response->assertSee('Blog Management');
        $response->assertSee('Test Blog Post');
        $response->assertSee('Create New Post');
    }

    public function test_admin_can_view_blog_create_form()
    {
        $response = $this->actingAs($this->user)->get('/admin/blogs/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin.blogs.create');
        $response->assertSee('Create New Blog Post');
        $response->assertSee('Title');
        $response->assertSee('Excerpt');
        $response->assertSee('Content');
        $response->assertSee('Meta Title');
        $response->assertSee('Meta Description');
    }

    public function test_admin_can_create_blog_with_valid_data()
    {
        $thumbnail = UploadedFile::fake()->image('blog-thumbnail.jpg');
        
        $blogData = [
            'title' => 'New Blog Post',
            'excerpt' => 'This is a test blog excerpt',
            'content' => 'This is the full blog content with **markdown** support',
            'thumbnail' => $thumbnail,
            'meta_title' => 'SEO Title for Blog Post',
            'meta_description' => 'SEO description for the blog post',
            'tags' => ['web', 'development', 'laravel'],
            'status' => 'published',
            'published_at' => now()->format('Y-m-d H:i:s')
        ];

        $response = $this->actingAs($this->user)->post('/admin/blogs', $blogData);

        $response->assertRedirect('/admin/blogs');
        $response->assertSessionHas('success', 'Blog post created successfully');

        $this->assertDatabaseHas('blogs', [
            'title' => 'New Blog Post',
            'slug' => 'new-blog-post',
            'excerpt' => 'This is a test blog excerpt',
            'status' => 'published'
        ]);

        Storage::disk('public')->assertExists('images/blogs/' . $thumbnail->hashName());
    }

    public function test_admin_cannot_create_blog_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->post('/admin/blogs', []);

        $response->assertSessionHasErrors(['title', 'excerpt', 'content']);
    }

    public function test_admin_can_create_draft_blog()
    {
        $blogData = [
            'title' => 'Draft Blog Post',
            'excerpt' => 'This is a draft excerpt',
            'content' => 'This is draft content',
            'status' => 'draft'
        ];

        $response = $this->actingAs($this->user)->post('/admin/blogs', $blogData);

        $response->assertRedirect('/admin/blogs');

        $this->assertDatabaseHas('blogs', [
            'title' => 'Draft Blog Post',
            'status' => 'draft',
            'published_at' => null
        ]);
    }

    public function test_admin_can_schedule_blog_for_future_publication()
    {
        $futureDate = now()->addDays(7);
        
        $blogData = [
            'title' => 'Scheduled Blog Post',
            'excerpt' => 'This post is scheduled',
            'content' => 'This content will be published later',
            'status' => 'published',
            'published_at' => $futureDate->format('Y-m-d H:i:s')
        ];

        $response = $this->actingAs($this->user)->post('/admin/blogs', $blogData);

        $this->assertDatabaseHas('blogs', [
            'title' => 'Scheduled Blog Post',
            'status' => 'published'
        ]);

        $blog = Blog::where('title', 'Scheduled Blog Post')->first();
        $this->assertEquals($futureDate->format('Y-m-d H:i'), $blog->published_at->format('Y-m-d H:i'));
    }

    public function test_admin_can_view_blog_edit_form()
    {
        $blog = Blog::factory()->create([
            'title' => 'Editable Blog Post',
            'excerpt' => 'Original excerpt'
        ]);

        $response = $this->actingAs($this->user)->get("/admin/blogs/{$blog->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('admin.blogs.edit');
        $response->assertSee('Edit Blog Post');
        $response->assertSee('Editable Blog Post');
        $response->assertSee('Original excerpt');
    }

    public function test_admin_can_update_blog()
    {
        $blog = Blog::factory()->create([
            'title' => 'Original Title',
            'excerpt' => 'Original excerpt'
        ]);

        $updateData = [
            'title' => 'Updated Blog Title',
            'excerpt' => 'Updated excerpt',
            'content' => 'Updated content',
            'meta_title' => 'Updated SEO Title',
            'tags' => ['updated', 'blog'],
            'status' => 'draft'
        ];

        $response = $this->actingAs($this->user)->put("/admin/blogs/{$blog->id}", $updateData);

        $response->assertRedirect('/admin/blogs');
        $response->assertSessionHas('success', 'Blog post updated successfully');

        $this->assertDatabaseHas('blogs', [
            'id' => $blog->id,
            'title' => 'Updated Blog Title',
            'excerpt' => 'Updated excerpt',
            'status' => 'draft'
        ]);
    }

    public function test_admin_can_delete_blog()
    {
        $blog = Blog::factory()->create([
            'title' => 'Blog to Delete'
        ]);

        $response = $this->actingAs($this->user)->delete("/admin/blogs/{$blog->id}");

        $response->assertRedirect('/admin/blogs');
        $response->assertSessionHas('success', 'Blog post deleted successfully');

        $this->assertDatabaseMissing('blogs', [
            'id' => $blog->id
        ]);
    }

    public function test_admin_can_publish_draft_blog()
    {
        $blog = Blog::factory()->create([
            'status' => 'draft',
            'published_at' => null
        ]);

        $response = $this->actingAs($this->user)->patch("/admin/blogs/{$blog->id}/publish");

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Blog post published successfully');

        $this->assertDatabaseHas('blogs', [
            'id' => $blog->id,
            'status' => 'published'
        ]);

        $blog->refresh();
        $this->assertNotNull($blog->published_at);
    }

    public function test_admin_can_unpublish_blog()
    {
        $blog = Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()
        ]);

        $response = $this->actingAs($this->user)->patch("/admin/blogs/{$blog->id}/unpublish");

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Blog post unpublished successfully');

        $this->assertDatabaseHas('blogs', [
            'id' => $blog->id,
            'status' => 'draft'
        ]);
    }

    public function test_admin_can_bulk_delete_blogs()
    {
        $blog1 = Blog::factory()->create();
        $blog2 = Blog::factory()->create();
        $blog3 = Blog::factory()->create();

        $response = $this->actingAs($this->user)->delete('/admin/blogs/bulk-delete', [
            'blog_ids' => [$blog1->id, $blog2->id]
        ]);

        $response->assertRedirect('/admin/blogs');
        $response->assertSessionHas('success', '2 blog posts deleted successfully');

        $this->assertDatabaseMissing('blogs', ['id' => $blog1->id]);
        $this->assertDatabaseMissing('blogs', ['id' => $blog2->id]);
        $this->assertDatabaseHas('blogs', ['id' => $blog3->id]);
    }

    public function test_admin_can_search_blogs()
    {
        Blog::factory()->create(['title' => 'Laravel Tutorial']);
        Blog::factory()->create(['title' => 'Vue.js Guide']);
        Blog::factory()->create(['title' => 'React Tips']);

        $response = $this->actingAs($this->user)->get('/admin/blogs?search=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel Tutorial');
        $response->assertDontSee('Vue.js Guide');
        $response->assertDontSee('React Tips');
    }

    public function test_admin_can_filter_blogs_by_status()
    {
        Blog::factory()->create(['title' => 'Published Blog', 'status' => 'published']);
        Blog::factory()->create(['title' => 'Draft Blog', 'status' => 'draft']);

        $response = $this->actingAs($this->user)->get('/admin/blogs?status=published');

        $response->assertStatus(200);
        $response->assertSee('Published Blog');
        $response->assertDontSee('Draft Blog');
    }

    public function test_admin_can_filter_blogs_by_tag()
    {
        Blog::factory()->create(['title' => 'Laravel Blog', 'tags' => ['laravel', 'php']]);
        Blog::factory()->create(['title' => 'JavaScript Blog', 'tags' => ['javascript', 'frontend']]);

        $response = $this->actingAs($this->user)->get('/admin/blogs?tag=laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel Blog');
        $response->assertDontSee('JavaScript Blog');
    }

    public function test_blog_slug_is_automatically_generated()
    {
        $blogData = [
            'title' => 'My Awesome Blog Post!',
            'excerpt' => 'Test excerpt',
            'content' => 'Test content',
            'status' => 'published'
        ];

        $response = $this->actingAs($this->user)->post('/admin/blogs', $blogData);

        $this->assertDatabaseHas('blogs', [
            'title' => 'My Awesome Blog Post!',
            'slug' => 'my-awesome-blog-post'
        ]);
    }

    public function test_blog_slug_is_unique()
    {
        Blog::factory()->create(['slug' => 'test-blog-post']);

        $blogData = [
            'title' => 'Test Blog Post',
            'excerpt' => 'Test excerpt',
            'content' => 'Test content',
            'status' => 'published'
        ];

        $response = $this->actingAs($this->user)->post('/admin/blogs', $blogData);

        $this->assertDatabaseHas('blogs', [
            'title' => 'Test Blog Post',
            'slug' => 'test-blog-post-1'
        ]);
    }

    public function test_admin_can_preview_blog_post()
    {
        $blog = Blog::factory()->create([
            'title' => 'Preview Blog Post',
            'content' => 'This is preview content',
            'status' => 'draft'
        ]);

        $response = $this->actingAs($this->user)->get("/admin/blogs/{$blog->id}/preview");

        $response->assertStatus(200);
        $response->assertSee('Preview Blog Post');
        $response->assertSee('This is preview content');
        $response->assertSee('PREVIEW MODE');
    }
}