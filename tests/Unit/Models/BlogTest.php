<?php

namespace Tests\Unit\Models;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_has_fillable_attributes()
    {
        $fillable = [
            'title', 'slug', 'excerpt', 'content', 'thumbnail',
            'meta_title', 'meta_description', 'tags', 'status', 'published_at'
        ];

        $blog = new Blog();
        $this->assertEquals($fillable, $blog->getFillable());
    }

    public function test_blog_casts_attributes_correctly()
    {
        $blog = Blog::factory()->create([
            'tags' => ['laravel', 'php'],
            'published_at' => now(),
        ]);

        $this->assertIsArray($blog->tags);
        $this->assertInstanceOf(\Carbon\Carbon::class, $blog->published_at);
    }

    public function test_slug_is_generated_automatically_on_creation()
    {
        $blog = Blog::create([
            'title' => 'Test Blog Post Title',
            'excerpt' => 'Test excerpt',
            'content' => 'Test content',
            'status' => 'published'
        ]);

        $this->assertEquals('test-blog-post-title', $blog->slug);
    }

    public function test_unique_slug_generation_when_duplicate_exists()
    {
        Blog::create([
            'title' => 'Test Blog Post',
            'excerpt' => 'Test excerpt',
            'content' => 'Test content',
            'status' => 'published'
        ]);

        $secondBlog = Blog::create([
            'title' => 'Test Blog Post',
            'excerpt' => 'Another test excerpt',
            'content' => 'Another test content',
            'status' => 'published'
        ]);

        $this->assertEquals('test-blog-post', Blog::first()->slug);
        $this->assertEquals('test-blog-post-1', $secondBlog->slug);
    }

    public function test_slug_is_updated_when_title_changes_and_no_original_slug()
    {
        $blog = Blog::create([
            'title' => 'Original Title',
            'excerpt' => 'Test excerpt',
            'content' => 'Test content',
            'status' => 'draft'
        ]);

        $blog->update(['title' => 'Updated Title', 'slug' => '']);

        $this->assertEquals('updated-title', $blog->fresh()->slug);
    }

    public function test_published_scope_returns_only_published_blogs()
    {
        Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay()
        ]);
        Blog::factory()->create([
            'status' => 'draft',
            'published_at' => now()->subDay()
        ]);
        Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->addDay()
        ]);
        Blog::factory()->create([
            'status' => 'published',
            'published_at' => null
        ]);

        $publishedBlogs = Blog::published()->get();

        $this->assertCount(1, $publishedBlogs);
        $this->assertEquals('published', $publishedBlogs->first()->status);
        $this->assertTrue($publishedBlogs->first()->published_at->isPast());
    }

    public function test_draft_scope_returns_only_draft_blogs()
    {
        Blog::factory()->create(['status' => 'published']);
        Blog::factory()->create(['status' => 'draft']);
        Blog::factory()->create(['status' => 'draft']);

        $draftBlogs = Blog::draft()->get();

        $this->assertCount(2, $draftBlogs);
        $this->assertTrue($draftBlogs->every(fn($blog) => $blog->status === 'draft'));
    }

    public function test_recent_scope_returns_recent_published_blogs_with_limit()
    {
        Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDays(3)
        ]);
        Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay()
        ]);
        Blog::factory()->create([
            'status' => 'draft',
            'published_at' => now()->subDays(2)
        ]);

        $recentBlogs = Blog::recent(1)->get();

        $this->assertCount(1, $recentBlogs);
        $this->assertTrue($recentBlogs->first()->published_at->isAfter(now()->subDays(2)));
    }

    public function test_by_tag_scope_filters_blogs_by_tag()
    {
        Blog::factory()->create(['tags' => ['laravel', 'php']]);
        Blog::factory()->create(['tags' => ['vue', 'javascript']]);
        Blog::factory()->create(['tags' => ['laravel', 'vue']]);

        $laravelBlogs = Blog::byTag('laravel')->get();
        $vueBlogs = Blog::byTag('vue')->get();

        $this->assertCount(2, $laravelBlogs);
        $this->assertCount(2, $vueBlogs);
    }

    public function test_scheduled_scope_returns_scheduled_blogs()
    {
        Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->addDay()
        ]);
        Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay()
        ]);
        Blog::factory()->create([
            'status' => 'draft',
            'published_at' => now()->addDay()
        ]);

        $scheduledBlogs = Blog::scheduled()->get();

        $this->assertCount(1, $scheduledBlogs);
        $this->assertEquals('published', $scheduledBlogs->first()->status);
        $this->assertTrue($scheduledBlogs->first()->published_at->isFuture());
    }

    public function test_is_published_method_returns_correct_boolean()
    {
        $publishedBlog = Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay()
        ]);
        $draftBlog = Blog::factory()->create(['status' => 'draft']);
        $scheduledBlog = Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->addDay()
        ]);

        $this->assertTrue($publishedBlog->isPublished());
        $this->assertFalse($draftBlog->isPublished());
        $this->assertFalse($scheduledBlog->isPublished());
    }

    public function test_is_draft_method_returns_correct_boolean()
    {
        $publishedBlog = Blog::factory()->create(['status' => 'published']);
        $draftBlog = Blog::factory()->create(['status' => 'draft']);

        $this->assertFalse($publishedBlog->isDraft());
        $this->assertTrue($draftBlog->isDraft());
    }

    public function test_is_scheduled_method_returns_correct_boolean()
    {
        $publishedBlog = Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay()
        ]);
        $scheduledBlog = Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->addDay()
        ]);
        $draftBlog = Blog::factory()->create(['status' => 'draft']);

        $this->assertFalse($publishedBlog->isScheduled());
        $this->assertTrue($scheduledBlog->isScheduled());
        $this->assertFalse($draftBlog->isScheduled());
    }

    public function test_route_key_name_is_slug()
    {
        $blog = new Blog();
        $this->assertEquals('slug', $blog->getRouteKeyName());
    }
}