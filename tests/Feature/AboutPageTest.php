<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Content;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        Content::create([
            'key' => 'about_profile_summary',
            'title' => 'Test Profile',
            'content' => 'Test profile content',
            'meta' => [
                'years_experience' => 5,
                'projects_completed' => 50
            ]
        ]);

        Content::create([
            'key' => 'about_skills',
            'title' => 'Test Skills',
            'content' => 'Test skills content',
            'meta' => [
                'categories' => [
                    [
                        'name' => 'Web Development',
                        'skills' => [
                            ['name' => 'Laravel', 'level' => 90, 'icon' => 'laravel']
                        ]
                    ]
                ]
            ]
        ]);

        Content::create([
            'key' => 'about_experience',
            'title' => 'Test Experience',
            'content' => 'Test experience content',
            'meta' => [
                'timeline' => [
                    [
                        'position' => 'Test Position',
                        'company' => 'Test Company',
                        'location' => 'Test Location',
                        'period' => '2020 - Present',
                        'description' => 'Test description',
                        'achievements' => ['Test achievement'],
                        'technologies' => ['Laravel']
                    ]
                ]
            ]
        ]);
    }

    public function test_about_page_displays_successfully()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertViewIs('pages.about');
        $response->assertSee('About');
        $response->assertSee('Aziz Khan');
    }

    public function test_about_page_displays_profile_summary()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('Test Profile');
        $response->assertSee('Test profile content');
        $response->assertSee('5+');
        $response->assertSee('Years Experience');
        $response->assertSee('50+');
        $response->assertSee('Projects Completed');
    }

    public function test_about_page_displays_skills_section()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('Test Skills');
        $response->assertSee('Web Development');
        $response->assertSee('Laravel');
        $response->assertSee('90%');
    }

    public function test_about_page_displays_experience_timeline()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('Test Experience');
        $response->assertSee('Test Position');
        $response->assertSee('Test Company');
        $response->assertSee('Test Location');
        $response->assertSee('2020 - Present');
        $response->assertSee('Test description');
        $response->assertSee('Test achievement');
    }

    public function test_about_page_includes_resume_download_link()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('Download Resume');
        $response->assertSee(route('resume.download'));
    }

    public function test_about_page_includes_contact_cta()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('Ready to Work Together?');
        $response->assertSee('Start a Project');
        $response->assertSee('View My Work');
    }

    public function test_about_page_works_with_default_content()
    {
        Content::truncate();

        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('My Story');
        $response->assertSee('Skills & Technologies');
        $response->assertSee('Work Experience');
    }

    public function test_resume_download_returns_file()
    {
        Storage::fake('local');
        Storage::put('public/documents/aziz-khan-resume.pdf', 'fake pdf content');

        $response = $this->get('/resume/download');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertDownload('Aziz-Khan-Resume.pdf');
    }

    public function test_resume_download_returns_404_when_file_missing()
    {
        Storage::fake('local');

        $response = $this->get('/resume/download');

        $response->assertStatus(404);
    }

    public function test_about_page_includes_seo_meta_tags()
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('<title>About - Aziz Khan</title>', false);
        $response->assertSee('2D/3D Artist & Web Developer passionate about creating digital experiences', false);
    }
}