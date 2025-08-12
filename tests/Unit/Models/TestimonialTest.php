<?php

namespace Tests\Unit\Models;

use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialTest extends TestCase
{
    use RefreshDatabase;

    public function test_testimonial_has_fillable_attributes()
    {
        $fillable = [
            'name', 'role', 'company', 'content', 'avatar', 'rating', 'is_featured', 'sort_order'
        ];

        $testimonial = new Testimonial();
        $this->assertEquals($fillable, $testimonial->getFillable());
    }

    public function test_testimonial_casts_attributes_correctly()
    {
        $testimonial = Testimonial::factory()->create([
            'is_featured' => true,
            'rating' => 5,
        ]);

        $this->assertIsBool($testimonial->is_featured);
        $this->assertIsInt($testimonial->rating);
    }

    public function test_featured_scope_returns_only_featured_testimonials()
    {
        Testimonial::factory()->create(['is_featured' => true]);
        Testimonial::factory()->create(['is_featured' => false]);
        Testimonial::factory()->create(['is_featured' => true]);

        $featuredTestimonials = Testimonial::featured()->get();

        $this->assertCount(2, $featuredTestimonials);
        $this->assertTrue($featuredTestimonials->every(fn($testimonial) => $testimonial->is_featured));
    }

    public function test_ordered_scope_orders_testimonials_by_sort_order()
    {
        $testimonial1 = Testimonial::factory()->create(['sort_order' => 3]);
        $testimonial2 = Testimonial::factory()->create(['sort_order' => 1]);
        $testimonial3 = Testimonial::factory()->create(['sort_order' => 2]);

        $orderedTestimonials = Testimonial::ordered()->get();

        $this->assertEquals($testimonial2->id, $orderedTestimonials[0]->id);
        $this->assertEquals($testimonial3->id, $orderedTestimonials[1]->id);
        $this->assertEquals($testimonial1->id, $orderedTestimonials[2]->id);
    }

    public function test_high_rated_scope_returns_testimonials_with_minimum_rating()
    {
        Testimonial::factory()->create(['rating' => 5]);
        Testimonial::factory()->create(['rating' => 3]);
        Testimonial::factory()->create(['rating' => 4]);
        Testimonial::factory()->create(['rating' => 2]);

        $highRatedTestimonials = Testimonial::highRated(4)->get();

        $this->assertCount(2, $highRatedTestimonials);
        $this->assertTrue($highRatedTestimonials->every(fn($testimonial) => $testimonial->rating >= 4));
    }

    public function test_high_rated_scope_uses_default_minimum_rating_of_4()
    {
        Testimonial::factory()->create(['rating' => 5]);
        Testimonial::factory()->create(['rating' => 3]);
        Testimonial::factory()->create(['rating' => 4]);

        $highRatedTestimonials = Testimonial::highRated()->get();

        $this->assertCount(2, $highRatedTestimonials);
        $this->assertTrue($highRatedTestimonials->every(fn($testimonial) => $testimonial->rating >= 4));
    }

    public function test_testimonial_can_have_company_and_role()
    {
        $testimonial = Testimonial::create([
            'name' => 'John Doe',
            'role' => 'Senior Developer',
            'company' => 'Tech Corp',
            'content' => 'Great work!',
            'rating' => 5
        ]);

        $this->assertEquals('Senior Developer', $testimonial->role);
        $this->assertEquals('Tech Corp', $testimonial->company);
    }

    public function test_testimonial_can_have_avatar()
    {
        $testimonial = Testimonial::create([
            'name' => 'Jane Smith',
            'content' => 'Excellent service!',
            'avatar' => 'avatars/jane-smith.jpg',
            'rating' => 5
        ]);

        $this->assertEquals('avatars/jane-smith.jpg', $testimonial->avatar);
    }

    public function test_testimonial_rating_validation_range()
    {
        $testimonial1 = Testimonial::factory()->create(['rating' => 1]);
        $testimonial2 = Testimonial::factory()->create(['rating' => 5]);

        $this->assertEquals(1, $testimonial1->rating);
        $this->assertEquals(5, $testimonial2->rating);
    }

    public function test_testimonial_sort_order_affects_ordering()
    {
        Testimonial::factory()->create(['name' => 'Alice', 'sort_order' => 10]);
        Testimonial::factory()->create(['name' => 'Bob', 'sort_order' => 5]);
        Testimonial::factory()->create(['name' => 'Charlie', 'sort_order' => 15]);

        $testimonials = Testimonial::ordered()->pluck('name')->toArray();

        $this->assertEquals(['Bob', 'Alice', 'Charlie'], $testimonials);
    }

    public function test_featured_testimonials_can_be_combined_with_other_scopes()
    {
        Testimonial::factory()->create(['is_featured' => true, 'rating' => 5, 'sort_order' => 2]);
        Testimonial::factory()->create(['is_featured' => true, 'rating' => 3, 'sort_order' => 1]);
        Testimonial::factory()->create(['is_featured' => false, 'rating' => 5, 'sort_order' => 3]);

        $featuredHighRated = Testimonial::featured()->highRated(4)->ordered()->get();

        $this->assertCount(1, $featuredHighRated);
        $this->assertTrue($featuredHighRated->first()->is_featured);
        $this->assertGreaterThanOrEqual(4, $featuredHighRated->first()->rating);
    }
}