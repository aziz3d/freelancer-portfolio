<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_testimonials_page_loads_successfully()
    {
        $response = $this->get(route('testimonials'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.testimonials');
        $response->assertSee('Testimonials');
        $response->assertSee('What Clients Say');
    }

    public function test_testimonials_page_displays_all_testimonials()
    {
        $testimonial1 = Testimonial::factory()->create([
            'name' => 'John Doe',
            'role' => 'CEO',
            'company' => 'Tech Corp',
            'content' => 'Excellent work on our website project!'
        ]);

        $testimonial2 = Testimonial::factory()->create([
            'name' => 'Jane Smith',
            'role' => 'Designer',
            'company' => 'Creative Agency',
            'content' => 'Amazing 3D modeling skills!'
        ]);

        $response = $this->get(route('testimonials'));

        $response->assertSee('John Doe');
        $response->assertSee('CEO');
        $response->assertSee('Tech Corp');
        $response->assertSee('Excellent work on our website project!');
        
        $response->assertSee('Jane Smith');
        $response->assertSee('Designer');
        $response->assertSee('Creative Agency');
        $response->assertSee('Amazing 3D modeling skills!');
    }

    public function test_testimonials_page_displays_testimonials_in_correct_order()
    {
        $testimonial1 = Testimonial::factory()->create([
            'name' => 'First Testimonial',
            'sort_order' => 2
        ]);

        $testimonial2 = Testimonial::factory()->create([
            'name' => 'Second Testimonial',
            'sort_order' => 1
        ]);

        $testimonial3 = Testimonial::factory()->create([
            'name' => 'Third Testimonial',
            'sort_order' => 3
        ]);

        $response = $this->get(route('testimonials'));
        $testimonials = $response->viewData('testimonials');

        $this->assertEquals('Second Testimonial', $testimonials->first()->name);
        $this->assertEquals('Third Testimonial', $testimonials->last()->name);
    }

    public function test_testimonials_page_displays_testimonial_avatars()
    {
        $testimonial = Testimonial::factory()->create([
            'name' => 'Avatar Test',
            'avatar' => 'avatars/test-avatar.jpg'
        ]);

        $response = $this->get(route('testimonials'));

        $response->assertSee('avatars/test-avatar.jpg');
        $response->assertSee('alt="Avatar Test"', false);
    }

    public function test_testimonials_page_displays_testimonial_ratings()
    {
        $testimonial = Testimonial::factory()->create([
            'name' => 'Rating Test',
            'rating' => 5
        ]);

        $response = $this->get(route('testimonials'));

        $response->assertSee('★★★★★');
    }

    public function test_testimonials_page_handles_different_rating_values()
    {
        $testimonial1 = Testimonial::factory()->create([
            'name' => 'Four Stars',
            'rating' => 4
        ]);

        $testimonial2 = Testimonial::factory()->create([
            'name' => 'Three Stars',
            'rating' => 3
        ]);

        $response = $this->get(route('testimonials'));

        $content = $response->getContent();
        $this->assertStringContainsString('★★★★☆', $content);
        $this->assertStringContainsString('★★★☆☆', $content);
    }

    public function test_testimonials_page_shows_featured_testimonials_first()
    {
        $regularTestimonial = Testimonial::factory()->create([
            'name' => 'Regular Client',
            'is_featured' => false,
            'sort_order' => 1
        ]);

        $featuredTestimonial = Testimonial::factory()->create([
            'name' => 'Featured Client',
            'is_featured' => true,
            'sort_order' => 2
        ]);

        $response = $this->get(route('testimonials'));
        $testimonials = $response->viewData('testimonials');

        $this->assertEquals('Featured Client', $testimonials->first()->name);
    }

    public function test_testimonials_page_shows_no_testimonials_message_when_empty()
    {
        $response = $this->get(route('testimonials'));

        $response->assertSee('No testimonials available yet');
    }

    public function test_testimonials_page_has_proper_seo_meta_tags()
    {
        $response = $this->get(route('testimonials'));

        $response->assertSee('<title>Testimonials - Aziz Khan</title>', false);
        $response->assertSee('<meta name="description"', false);
        $response->assertSee('content="Client testimonials and reviews for Aziz Khan"', false);
    }

    public function test_testimonials_page_includes_contact_cta()
    {
        $response = $this->get(route('testimonials'));

        $response->assertSee('Ready to work together?');
        $response->assertSee('Get In Touch');
    }

    public function test_testimonials_page_displays_company_information()
    {
        $testimonial = Testimonial::factory()->create([
            'name' => 'Client Name',
            'role' => 'Project Manager',
            'company' => 'Amazing Company Inc.'
        ]);

        $response = $this->get(route('testimonials'));

        $response->assertSee('Project Manager at Amazing Company Inc.');
    }

    public function test_testimonials_page_handles_missing_company_information()
    {
        $testimonial = Testimonial::factory()->create([
            'name' => 'Freelancer',
            'role' => 'Independent Designer',
            'company' => null
        ]);

        $response = $this->get(route('testimonials'));

        $response->assertSee('Independent Designer');
        $response->assertDontSee(' at ');
    }
}