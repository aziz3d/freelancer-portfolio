<?php

namespace Tests\Browser;

use App\Models\Project;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class JavaScriptInteractionTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        
        Project::factory()->count(5)->create([
            'status' => 'published',
            'technologies' => ['Laravel', 'Vue.js', 'React'],
            'tags' => ['web', 'frontend', 'backend']
        ]);
        Blog::factory()->count(3)->create(['status' => 'published', 'published_at' => now()]);
        Service::factory()->count(4)->create(['is_active' => true]);
        Testimonial::factory()->count(3)->create(['is_featured' => true]);
    }

    public function test_mobile_menu_toggle_functionality()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 667)
                    ->visit('/')
                    ->assertMissing('.mobile-menu.open')
                    ->click('.mobile-menu-button')
                    ->pause(300)
                    ->assertVisible('.mobile-menu.open')
                    ->click('.mobile-menu-button')
                    ->pause(300)
                    ->assertMissing('.mobile-menu.open');
        });
    }

    public function test_project_filtering_by_technology()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects')
                    ->assertVisible('.project-card')
                    ->select('.technology-filter', 'Laravel')
                    ->pause(500)
                    ->assertVisible('.project-card[data-technology*="Laravel"]')
                    ->select('.technology-filter', 'Vue.js')
                    ->pause(500)
                    ->assertVisible('.project-card[data-technology*="Vue.js"]');
        });
    }

    public function test_project_filtering_by_tags()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects')
                    ->assertVisible('.project-card')
                    ->click('.tag-filter[data-tag="web"]')
                    ->pause(500)
                    ->assertVisible('.project-card[data-tags*="web"]')
                    ->click('.tag-filter[data-tag="frontend"]')
                    ->pause(500)
                    ->assertVisible('.project-card[data-tags*="frontend"]');
        });
    }

    public function test_project_modal_open_and_close()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects')
                    ->assertMissing('.project-modal')
                    ->click('.project-card:first-child .view-details')
                    ->pause(500)
                    ->assertVisible('.project-modal')
                    ->assertSee('Project Details')
                    ->click('.project-modal .close-button')
                    ->pause(500)
                    ->assertMissing('.project-modal');
        });
    }

    public function test_project_modal_keyboard_close()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects')
                    ->click('.project-card:first-child .view-details')
                    ->pause(500)
                    ->assertVisible('.project-modal')
                    ->keys('body', '{escape}')
                    ->pause(500)
                    ->assertMissing('.project-modal');
        });
    }

    public function test_contact_form_validation_feedback()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                    ->click('button[type="submit"]')
                    ->pause(500)
                    ->assertVisible('.error-message')
                    ->assertSee('Please enter your name')
                    ->type('input[name="name"]', 'John Doe')
                    ->click('button[type="submit"]')
                    ->pause(500)
                    ->assertSee('Please enter your email');
        });
    }

    public function test_contact_form_success_message()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                    ->type('input[name="name"]', 'John Doe')
                    ->type('input[name="email"]', 'john@example.com')
                    ->type('textarea[name="message"]', 'This is a test message')
                    ->click('button[type="submit"]')
                    ->pause(2000)
                    ->assertSee('Thank you for your message');
        });
    }

    public function test_smooth_scrolling_navigation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('a[href="#featured-projects"]')
                    ->pause(1000)
                    ->assertVisible('.featured-projects')
                    ->click('a[href="#testimonials"]')
                    ->pause(1000)
                    ->assertVisible('.testimonials-section');
        });
    }

    public function test_image_lazy_loading_intersection_observer()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->script('window.scrollTo(0, 0);')
                    ->pause(500)
                    ->assertAttribute('img[data-lazy]:first', 'src', '')
                    ->script('window.scrollTo(0, 1000);')
                    ->pause(1000)
                    ->assertAttributeIsNot('img[data-lazy]:first', 'src', '');
        });
    }

    public function test_testimonials_carousel_navigation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->scrollIntoView('.testimonials-section')
                    ->assertVisible('.testimonial-slide:first-child')
                    ->click('.testimonial-next')
                    ->pause(500)
                    ->assertVisible('.testimonial-slide:nth-child(2)')
                    ->click('.testimonial-prev')
                    ->pause(500)
                    ->assertVisible('.testimonial-slide:first-child');
        });
    }

    public function test_testimonials_auto_play()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->scrollIntoView('.testimonials-section')
                    ->assertVisible('.testimonial-slide:first-child')
                    ->pause(5000)
                    ->assertVisible('.testimonial-slide:nth-child(2)');
        });
    }

    public function test_search_functionality_real_time()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/blog')
                    ->assertVisible('.blog-card')
                    ->type('.search-input', 'Laravel')
                    ->pause(500)
                    ->assertVisible('.blog-card[data-title*="Laravel"]')
                    ->clear('.search-input')
                    ->type('.search-input', 'Vue')
                    ->pause(500)
                    ->assertVisible('.blog-card[data-title*="Vue"]');
        });
    }

    public function test_back_to_top_button()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertMissing('.back-to-top')
                    ->script('window.scrollTo(0, 1000);')
                    ->pause(500)
                    ->assertVisible('.back-to-top')
                    ->click('.back-to-top')
                    ->pause(1000)
                    ->script('return window.pageYOffset;')
                    ->assertScript('return window.pageYOffset;', 0);
        });
    }

    public function test_form_field_focus_animations()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                    ->click('input[name="name"]')
                    ->assertHasClass('input[name="name"]', 'focused')
                    ->click('input[name="email"]')
                    ->assertHasClass('input[name="email"]', 'focused')
                    ->assertMissingClass('input[name="name"]', 'focused');
        });
    }

    public function test_loading_states_during_form_submission()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                    ->type('input[name="name"]', 'John Doe')
                    ->type('input[name="email"]', 'john@example.com')
                    ->type('textarea[name="message"]', 'Test message')
                    ->click('button[type="submit"]')
                    ->assertVisible('.loading-spinner')
                    ->assertSee('Sending...')
                    ->pause(2000)
                    ->assertMissing('.loading-spinner');
        });
    }

    public function test_tooltip_hover_interactions()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/about')
                    ->mouseover('.skill-icon:first-child')
                    ->pause(300)
                    ->assertVisible('.tooltip')
                    ->mouseout('.skill-icon:first-child')
                    ->pause(300)
                    ->assertMissing('.tooltip');
        });
    }

    public function test_accordion_expand_collapse()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/services')
                    ->assertMissing('.service-details:first-child')
                    ->click('.service-header:first-child')
                    ->pause(300)
                    ->assertVisible('.service-details:first-child')
                    ->click('.service-header:first-child')
                    ->pause(300)
                    ->assertMissing('.service-details:first-child');
        });
    }

    public function test_dark_mode_toggle()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertMissingClass('html', 'dark')
                    ->click('.dark-mode-toggle')
                    ->pause(300)
                    ->assertHasClass('html', 'dark')
                    ->click('.dark-mode-toggle')
                    ->pause(300)
                    ->assertMissingClass('html', 'dark');
        });
    }

    public function test_copy_to_clipboard_functionality()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                    ->click('.copy-email')
                    ->pause(500)
                    ->assertSee('Email copied to clipboard')
                    ->pause(2000)
                    ->assertDontSee('Email copied to clipboard');
        });
    }

    public function test_infinite_scroll_blog_posts()
    {
        Blog::factory()->count(20)->create(['status' => 'published', 'published_at' => now()]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/blog')
                    ->assertVisible('.blog-card')
                    ->script('window.scrollTo(0, document.body.scrollHeight);')
                    ->pause(2000)
                    ->assertVisible('.loading-more')
                    ->pause(3000)
                    ->assertMissing('.loading-more');
        });
    }

    public function test_social_share_buttons()
    {
        $this->browse(function (Browser $browser) {
            $blog = Blog::first();
            
            $browser->visit("/blog/{$blog->slug}")
                    ->click('.share-twitter')
                    ->pause(1000)
                    ->assertUrlContains('twitter.com')
                    ->back()
                    ->click('.share-linkedin')
                    ->pause(1000)
                    ->assertUrlContains('linkedin.com');
        });
    }

    public function test_image_gallery_lightbox()
    {
        $this->browse(function (Browser $browser) {
            $project = Project::first();
            
            $browser->visit("/projects/{$project->slug}")
                    ->click('.project-image:first-child')
                    ->pause(500)
                    ->assertVisible('.lightbox')
                    ->assertVisible('.lightbox-image')
                    ->click('.lightbox-next')
                    ->pause(300)
                    ->click('.lightbox-close')
                    ->pause(300)
                    ->assertMissing('.lightbox');
        });
    }
}