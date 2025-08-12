<?php

namespace Tests\Unit\Models;

use App\Models\Content;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_has_fillable_attributes()
    {
        $fillable = [
            'key', 'title', 'content', 'meta'
        ];

        $content = new Content();
        $this->assertEquals($fillable, $content->getFillable());
    }

    public function test_content_casts_attributes_correctly()
    {
        $content = Content::factory()->create([
            'meta' => ['seo_title' => 'Test Title', 'seo_description' => 'Test Description'],
        ]);

        $this->assertIsArray($content->meta);
    }

    public function test_by_key_scope_filters_content_by_key()
    {
        Content::factory()->create(['key' => 'test_homepage_hero']);
        Content::factory()->create(['key' => 'test_about_intro']);

        $heroContent = Content::byKey('test_homepage_hero')->get();
        $aboutContent = Content::byKey('test_about_intro')->get();

        $this->assertCount(1, $heroContent);
        $this->assertCount(1, $aboutContent);
        $this->assertTrue($heroContent->every(fn($content) => $content->key === 'test_homepage_hero'));
    }

    public function test_content_can_store_dynamic_content()
    {
        $content = Content::create([
            'key' => 'test_homepage_hero_2',
            'title' => 'Welcome to My Portfolio',
            'content' => 'I am a 2D/3D Artist & Web Developer',
            'meta' => [
                'button_text' => 'View Projects',
                'button_url' => '/projects',
                'background_image' => 'hero-bg.jpg'
            ]
        ]);

        $this->assertEquals('test_homepage_hero_2', $content->key);
        $this->assertEquals('Welcome to My Portfolio', $content->title);
        $this->assertEquals('I am a 2D/3D Artist & Web Developer', $content->content);
        $this->assertIsArray($content->meta);
        $this->assertEquals('View Projects', $content->meta['button_text']);
    }

    public function test_content_can_have_empty_meta()
    {
        $content = Content::create([
            'key' => 'simple_content',
            'title' => 'Simple Title',
            'content' => 'Simple content without meta',
            'meta' => null
        ]);

        $this->assertNull($content->meta);
    }

    public function test_content_can_store_complex_meta_data()
    {
        $complexMeta = [
            'seo' => [
                'title' => 'SEO Title',
                'description' => 'SEO Description',
                'keywords' => ['web', 'development', '3d']
            ],
            'display' => [
                'show_title' => true,
                'layout' => 'grid',
                'columns' => 3
            ],
            'social' => [
                'og_image' => 'social-image.jpg',
                'twitter_card' => 'summary_large_image'
            ]
        ];

        $content = Content::create([
            'key' => 'complex_content',
            'title' => 'Complex Content',
            'content' => 'Content with complex meta',
            'meta' => $complexMeta
        ]);

        $this->assertEquals($complexMeta, $content->meta);
        $this->assertEquals('SEO Title', $content->meta['seo']['title']);
        $this->assertEquals(3, $content->meta['display']['columns']);
        $this->assertIsArray($content->meta['seo']['keywords']);
    }

    public function test_content_key_should_be_unique()
    {
        Content::create([
            'key' => 'test_unique_key_1',
            'title' => 'First Content',
            'content' => 'First content'
        ]);

        $secondContent = Content::create([
            'key' => 'test_unique_key_2',
            'title' => 'Second Content',
            'content' => 'Second content'
        ]);

        $this->assertCount(1, Content::byKey('test_unique_key_1')->get());
        $this->assertCount(1, Content::byKey('test_unique_key_2')->get());
        $this->assertNotEquals($secondContent->key, Content::byKey('test_unique_key_1')->first()->key);
    }

    public function test_content_can_be_retrieved_by_key_for_dynamic_pages()
    {
        Content::create([
            'key' => 'test_homepage_stats',
            'title' => 'Portfolio Stats',
            'content' => null,
            'meta' => [
                'projects_completed' => 50,
                'happy_clients' => 25,
                'years_experience' => 5,
                'technologies_used' => 15
            ]
        ]);

        $statsContent = Content::byKey('test_homepage_stats')->first();

        $this->assertNotNull($statsContent);
        $this->assertEquals(50, $statsContent->meta['projects_completed']);
        $this->assertEquals(25, $statsContent->meta['happy_clients']);
    }

    public function test_content_can_store_rich_text_content()
    {
        $richContent = '<h2>About Me</h2><p>I am a passionate developer with <strong>5 years</strong> of experience.</p>';

        $content = Content::create([
            'key' => 'about_intro',
            'title' => 'About Introduction',
            'content' => $richContent
        ]);

        $this->assertEquals($richContent, $content->content);
        $this->assertStringContainsString('<h2>About Me</h2>', $content->content);
    }
}