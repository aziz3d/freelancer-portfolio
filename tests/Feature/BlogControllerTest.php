<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_displays_published_blogs()
    {
        $publishedBlogs = Blog::factory()->count(3)->published()->create();
        Blog::factory()->create(['status' => 'draft']);

        $response = $this->get(route('blog.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.blog.index');
        $response->assertViewHas('blogs');
        
        foreach ($publishedBlogs as $blog) {
            $response->assertSee($blog->title);
        }
    }

    public function test_blog_index_orders_blogs_by_published_date_desc()
    {
        $olderBlog = Blog::factory()->published()->create([
            'published_at' => now()->subDays(2)
        ]);
        
        $newerBlog = Blog::factory()->published()->create([
            'published_at' => now()->subDay()
        ]);

        $response = $this->get(route('blog.index'));
        
        $blogs = $response->viewData('blogs');
        $this->assertEquals($newerBlog->id, $blogs->first()->id);
    }

    public function test_blog_show_displays_published_blog()
    {
        $blog = Blog::factory()->published()->create();

        $response = $this->get(route('blog.show', $blog));

        $response->assertStatus(200);
        $response->assertViewIs('pages.blog.show');
        $response->assertViewHas('blog', $blog);
        $response->assertSee($blog->title);
        $response->assertSee($blog->content);
    }

    public function test_blog_show_returns_404_for_draft_blog()
    {
        $blog = Blog::factory()->create(['status' => 'draft']);

        $response = $this->get(route('blog.show', $blog));

        $response->assertStatus(404);
    }

    public function test_blog_show_returns_404_for_scheduled_blog()
    {
        $blog = Blog::factory()->create([
            'status' => 'published',
            'published_at' => now()->addDay()
        ]);

        $response = $this->get(route('blog.show', $blog));

        $response->assertStatus(404);
    }

    public function test_blog_show_displays_related_articles()
    {
        $tag = 'laravel';
        
        $blog = Blog::factory()->published()->create([
            'tags' => [$tag, 'php']
        ]);
        
        $relatedBlog = Blog::factory()->published()->create([
            'tags' => [$tag, 'web-development']
        ]);
        
        Blog::factory()->published()->create([
            'tags' => ['javascript', 'react']
        ]);

        $response = $this->get(route('blog.show', $blog));

        $response->assertStatus(200);
        $response->assertViewHas('relatedBlogs');
        
        $relatedBlogs = $response->viewData('relatedBlogs');
        $this->assertCount(1, $relatedBlogs);
        $this->assertEquals($relatedBlog->id, $relatedBlogs->first()->id);
    }

    public function test_blog_show_excludes_current_blog_from_related()
    {
        $tag = 'laravel';
        
        $blogs = Blog::factory()->count(3)->published()->create([
            'tags' => [$tag]
        ]);
        
        $currentBlog = $blogs->first();

        $response = $this->get(route('blog.show', $currentBlog));

        $relatedBlogs = $response->viewData('relatedBlogs');
        
        $this->assertFalse($relatedBlogs->contains('id', $currentBlog->id));
    }

    public function test_blog_show_limits_related_articles_to_three()
    {
        $tag = 'laravel';
        
        $blog = Blog::factory()->published()->create([
            'tags' => [$tag]
        ]);
        
        Blog::factory()->count(5)->published()->create([
            'tags' => [$tag]
        ]);

        $response = $this->get(route('blog.show', $blog));

        $relatedBlogs = $response->viewData('relatedBlogs');
        $this->assertCount(3, $relatedBlogs);
    }

    public function test_blog_show_displays_navigation_links()
    {
        $previousBlog = Blog::factory()->published()->create([
            'published_at' => now()->subDays(2)
        ]);
        
        $currentBlog = Blog::factory()->published()->create([
            'published_at' => now()->subDay()
        ]);
        
        $nextBlog = Blog::factory()->published()->create([
            'published_at' => now()
        ]);

        $response = $this->get(route('blog.show', $currentBlog));

        $response->assertViewHas('previousBlog', $previousBlog);
        $response->assertViewHas('nextBlog', $nextBlog);
    }

    public function test_blog_index_shows_empty_state_when_no_blogs()
    {
        $response = $this->get(route('blog.index'));

        $response->assertStatus(200);
        $response->assertSee('No blog posts');
    }

    public function test_blog_show_includes_seo_meta_tags()
    {
        $blog = Blog::factory()->published()->create([
            'meta_title' => 'Custom Meta Title',
            'meta_description' => 'Custom meta description for SEO'
        ]);

        $response = $this->get(route('blog.show', $blog));

        $response->assertSee('Custom Meta Title', false);
        $response->assertSee('Custom meta description for SEO', false);
    }
}