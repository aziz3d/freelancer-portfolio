<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use App\Models\Blog;
use App\Services\SEOService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SEOTest extends TestCase
{
    use RefreshDatabase;

    protected $seoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seoService = app(SEOService::class);
    }

    public function it_generates_sitemap_xml()
    {
        Project::factory()->published()->create(['slug' => 'test-project']);
        Blog::factory()->published()->create(['slug' => 'test-blog']);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $content = $response->getContent();
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $content);
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $content);
        $this->assertStringContainsString('<loc>' . url('/') . '</loc>', $content);
        $this->assertStringContainsString('<loc>' . route('projects.show', 'test-project') . '</loc>', $content);
        $this->assertStringContainsString('<loc>' . route('blog.show', 'test-blog') . '</loc>', $content);
    }

    public function it_generates_robots_txt()
    {
        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');

        $content = $response->getContent();
        $this->assertStringContainsString('User-agent: *', $content);
        $this->assertStringContainsString('Allow: /', $content);
        $this->assertStringContainsString('Disallow: /admin/', $content);
        $this->assertStringContainsString('Sitemap: ' . url('/sitemap.xml'), $content);
    }

    public function it_generates_home_page_meta_tags()
    {
        $metaTags = $this->seoService->generateMetaTags('home');

        $this->assertArrayHasKey('title', $metaTags);
        $this->assertArrayHasKey('description', $metaTags);
        $this->assertArrayHasKey('keywords', $metaTags);
        $this->assertArrayHasKey('ogType', $metaTags);
        $this->assertArrayHasKey('ogUrl', $metaTags);
        $this->assertArrayHasKey('ogImage', $metaTags);
        $this->assertArrayHasKey('canonical', $metaTags);
        $this->assertArrayHasKey('structuredData', $metaTags);

        $this->assertEquals('website', $metaTags['ogType']);
        $this->assertEquals(url('/'), $metaTags['ogUrl']);
        $this->assertStringContainsString('Aziz Khan', $metaTags['title']);
    }

    public function it_generates_project_specific_meta_tags()
    {
        $project = Project::factory()->published()->create([
            'title' => 'Test Project',
            'description' => 'This is a test project description',
            'slug' => 'test-project',
            'technologies' => ['Laravel', 'Vue.js'],
            'tags' => ['web', 'development']
        ]);

        $metaTags = $this->seoService->generateMetaTags('projects', $project);

        $this->assertStringContainsString('Test Project', $metaTags['title']);
        $this->assertStringContainsString('This is a test project description', $metaTags['description']);
        $this->assertStringContainsString('Laravel', $metaTags['keywords']);
        $this->assertStringContainsString('Vue.js', $metaTags['keywords']);
        $this->assertEquals('article', $metaTags['ogType']);
        $this->assertEquals(route('projects.show', 'test-project'), $metaTags['ogUrl']);
    }

    public function it_generates_blog_specific_meta_tags()
    {
        $blog = Blog::factory()->published()->create([
            'title' => 'Test Blog Post',
            'excerpt' => 'This is a test blog excerpt',
            'slug' => 'test-blog-post',
            'meta_title' => 'Custom Meta Title',
            'meta_description' => 'Custom meta description',
            'tags' => ['tutorial', 'laravel']
        ]);

        $metaTags = $this->seoService->generateMetaTags('blog', $blog);

        $this->assertEquals('Custom Meta Title', $metaTags['title']);
        $this->assertEquals('Custom meta description', $metaTags['description']);
        $this->assertStringContainsString('tutorial', $metaTags['keywords']);
        $this->assertStringContainsString('laravel', $metaTags['keywords']);
        $this->assertEquals('article', $metaTags['ogType']);
        $this->assertEquals(route('blog.show', 'test-blog-post'), $metaTags['ogUrl']);
    }


    public function it_generates_structured_data_for_person()
    {
        $metaTags = $this->seoService->generateMetaTags('home');
        $structuredData = $metaTags['structuredData'];

        $this->assertEquals('https://schema.org', $structuredData['@context']);
        $this->assertEquals('Person', $structuredData['@type']);
        $this->assertEquals('Aziz Khan', $structuredData['name']);
        $this->assertEquals('2D/3D Artist & Web Developer', $structuredData['jobTitle']);
        $this->assertArrayHasKey('sameAs', $structuredData);
        $this->assertArrayHasKey('knowsAbout', $structuredData);
        $this->assertArrayHasKey('hasOccupation', $structuredData);
    }

    public function it_generates_structured_data_for_project()
    {
        $project = Project::factory()->published()->create([
            'title' => 'Test Project',
            'description' => 'Test description',
            'slug' => 'test-project',
            'tags' => ['web', 'development']
        ]);

        $metaTags = $this->seoService->generateMetaTags('projects', $project);
        $structuredData = $metaTags['structuredData'];

        $this->assertEquals('https://schema.org', $structuredData['@context']);
        $this->assertEquals('CreativeWork', $structuredData['@type']);
        $this->assertEquals('Test Project', $structuredData['name']);
        $this->assertEquals('Test description', $structuredData['description']);
        $this->assertArrayHasKey('creator', $structuredData);
        $this->assertEquals('Aziz Khan', $structuredData['creator']['name']);
    }

    public function it_generates_structured_data_for_blog_post()
    {
        $blog = Blog::factory()->published()->create([
            'title' => 'Test Blog Post',
            'excerpt' => 'Test excerpt',
            'slug' => 'test-blog-post',
            'tags' => ['tutorial', 'laravel']
        ]);

        $metaTags = $this->seoService->generateMetaTags('blog', $blog);
        $structuredData = $metaTags['structuredData'];

        $this->assertEquals('https://schema.org', $structuredData['@context']);
        $this->assertEquals('BlogPosting', $structuredData['@type']);
        $this->assertEquals('Test Blog Post', $structuredData['headline']);
        $this->assertEquals('Test excerpt', $structuredData['description']);
        $this->assertArrayHasKey('author', $structuredData);
        $this->assertEquals('Aziz Khan', $structuredData['author']['name']);
        $this->assertArrayHasKey('publisher', $structuredData);
        $this->assertArrayHasKey('mainEntityOfPage', $structuredData);
    }

    public function sitemap_includes_all_static_pages()
    {
        $sitemapData = $this->seoService->generateSitemapData();
        $urls = collect($sitemapData)->pluck('url');

        $this->assertTrue($urls->contains(url('/')));
        $this->assertTrue($urls->contains(route('about')));
        $this->assertTrue($urls->contains(route('projects.index')));
        $this->assertTrue($urls->contains(route('blog.index')));
        $this->assertTrue($urls->contains(route('services')));
        $this->assertTrue($urls->contains(route('testimonials')));
        $this->assertTrue($urls->contains(route('contact')));
    }

    public function sitemap_includes_published_projects_and_blogs()
    {
        $project = Project::factory()->published()->create(['slug' => 'published-project']);
        $blog = Blog::factory()->published()->create(['slug' => 'published-blog']);
        
        Project::factory()->draft()->create(['slug' => 'draft-project']);
        Blog::factory()->draft()->create(['slug' => 'draft-blog']);

        $sitemapData = $this->seoService->generateSitemapData();
        $urls = collect($sitemapData)->pluck('url');

        $this->assertTrue($urls->contains(route('projects.show', 'published-project')));
        $this->assertTrue($urls->contains(route('blog.show', 'published-blog')));
        $this->assertFalse($urls->contains(route('projects.show', 'draft-project')));
        $this->assertFalse($urls->contains(route('blog.show', 'draft-blog')));
    }

    public function robots_txt_content_is_properly_formatted()
    {
        $robotsContent = $this->seoService->generateRobotsTxt();

        $this->assertStringContainsString('User-agent: *', $robotsContent);
        $this->assertStringContainsString('Allow: /', $robotsContent);
        $this->assertStringContainsString('Disallow: /admin/', $robotsContent);
        $this->assertStringContainsString('Disallow: /storage/', $robotsContent);
        $this->assertStringContainsString('Disallow: /vendor/', $robotsContent);
        $this->assertStringContainsString('Sitemap: ' . url('/sitemap.xml'), $robotsContent);
    }
}