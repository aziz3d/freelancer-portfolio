<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use App\Models\Blog;
use App\Services\SEOService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SEOServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $seoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seoService = new SEOService();
    }

    public function it_generates_default_meta_tags_for_unknown_page()
    {
        $metaTags = $this->seoService->generateMetaTags('unknown-page');

        $this->assertArrayHasKey('title', $metaTags);
        $this->assertArrayHasKey('description', $metaTags);
        $this->assertArrayHasKey('keywords', $metaTags);
        $this->assertArrayHasKey('ogType', $metaTags);
        $this->assertArrayHasKey('ogUrl', $metaTags);
        $this->assertArrayHasKey('ogImage', $metaTags);
        $this->assertArrayHasKey('canonical', $metaTags);

        $this->assertEquals('website', $metaTags['ogType']);
        $this->assertStringContainsString('Aziz Khan', $metaTags['title']);
    }

    public function it_generates_about_page_meta_tags()
    {
        $metaTags = $this->seoService->generateMetaTags('about');

        $this->assertStringContainsString('About', $metaTags['title']);
        $this->assertStringContainsString('background', $metaTags['description']);
        $this->assertStringContainsString('Resume', $metaTags['keywords']);
        $this->assertEquals('profile', $metaTags['ogType']);
        $this->assertEquals(route('about'), $metaTags['ogUrl']);
    }

    public function it_generates_services_page_meta_tags()
    {
        $metaTags = $this->seoService->generateMetaTags('services');

        $this->assertStringContainsString('Services', $metaTags['title']);
        $this->assertStringContainsString('Web Development', $metaTags['description']);
        $this->assertStringContainsString('3D Modeling', $metaTags['description']);
        $this->assertStringContainsString('Retopology', $metaTags['keywords']);
        $this->assertEquals(route('services'), $metaTags['ogUrl']);
    }

    public function it_generates_contact_page_meta_tags()
    {
        $metaTags = $this->seoService->generateMetaTags('contact');

        $this->assertStringContainsString('Contact', $metaTags['title']);
        $this->assertStringContainsString('Get in touch', $metaTags['description']);
        $this->assertStringContainsString('Hire', $metaTags['keywords']);
        $this->assertEquals(route('contact'), $metaTags['ogUrl']);
    }

    public function it_generates_testimonials_page_meta_tags()
    {
        $metaTags = $this->seoService->generateMetaTags('testimonials');

        $this->assertStringContainsString('Testimonials', $metaTags['title']);
        $this->assertStringContainsString('clients and colleagues', $metaTags['description']);
        $this->assertStringContainsString('Reviews', $metaTags['keywords']);
        $this->assertEquals(route('testimonials'), $metaTags['ogUrl']);
    }

    public function it_handles_project_without_technologies_and_tags()
    {
        $project = Project::factory()->published()->make([
            'title' => 'Simple Project',
            'description' => 'Simple description',
            'slug' => 'simple-project',
            'technologies' => null,
            'tags' => null
        ]);

        $metaTags = $this->seoService->generateMetaTags('projects', $project);

        $this->assertStringContainsString('Simple Project', $metaTags['title']);
        $this->assertStringContainsString('Simple description', $metaTags['description']);
        $this->assertEquals('Project, Simple Project', $metaTags['keywords']);
    }

    public function it_handles_blog_without_meta_fields()
    {
        $blog = Blog::factory()->published()->make([
            'title' => 'Simple Blog',
            'excerpt' => 'Simple excerpt',
            'content' => 'This is the full content of the blog post.',
            'slug' => 'simple-blog',
            'meta_title' => null,
            'meta_description' => null,
            'tags' => null
        ]);

        $metaTags = $this->seoService->generateMetaTags('blog', $blog);

        $this->assertEquals('Simple Blog - Blog by Aziz Khan', $metaTags['title']);
        $this->assertEquals('Simple excerpt', $metaTags['description']);
        $this->assertEquals('Blog, Article, Simple Blog', $metaTags['keywords']);
    }

    public function it_truncates_long_descriptions()
    {
        $longContent = str_repeat('This is a very long content. ', 20);
        $blog = Blog::factory()->published()->make([
            'title' => 'Long Blog',
            'excerpt' => null,
            'content' => $longContent,
            'slug' => 'long-blog',
            'meta_description' => null
        ]);

        $metaTags = $this->seoService->generateMetaTags('blog', $blog);

        $this->assertLessThanOrEqual(160, strlen($metaTags['description']));
    }

    public function it_generates_proper_structured_data_types()
    {
        $pages = ['home', 'about', 'projects', 'blog', 'services', 'testimonials', 'contact'];

        foreach ($pages as $page) {
            $metaTags = $this->seoService->generateMetaTags($page);
            $structuredData = $metaTags['structuredData'];

            $this->assertArrayHasKey('@context', $structuredData);
            $this->assertArrayHasKey('@type', $structuredData);
            $this->assertEquals('https://schema.org', $structuredData['@context']);
        }
    }

    public function sitemap_data_has_required_fields()
    {
        Project::factory()->published()->create();
        Blog::factory()->published()->create();

        $sitemapData = $this->seoService->generateSitemapData();

        $this->assertNotEmpty($sitemapData);

        foreach ($sitemapData as $url) {
            $this->assertArrayHasKey('url', $url);
            $this->assertArrayHasKey('lastmod', $url);
            $this->assertArrayHasKey('changefreq', $url);
            $this->assertArrayHasKey('priority', $url);
        }
    }

    public function sitemap_priorities_are_valid()
    {
        $sitemapData = $this->seoService->generateSitemapData();

        foreach ($sitemapData as $url) {
            $priority = (float) $url['priority'];
            $this->assertGreaterThanOrEqual(0.0, $priority);
            $this->assertLessThanOrEqual(1.0, $priority);
        }
    }

    public function sitemap_changefreq_values_are_valid()
    {
        $validFrequencies = ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'];
        $sitemapData = $this->seoService->generateSitemapData();

        foreach ($sitemapData as $url) {
            $this->assertContains($url['changefreq'], $validFrequencies);
        }
    }
}