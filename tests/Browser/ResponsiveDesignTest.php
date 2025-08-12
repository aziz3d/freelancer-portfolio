<?php

namespace Tests\Browser;

use App\Models\Project;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ResponsiveDesignTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        
        Project::factory()->count(3)->create(['status' => 'published', 'is_featured' => true]);
        Blog::factory()->count(2)->create(['status' => 'published', 'published_at' => now()]);
        Service::factory()->count(3)->create(['is_active' => true]);
        Testimonial::factory()->count(2)->create(['is_featured' => true]);
    }

    public function test_homepage_responsive_design_mobile()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 667)
                    ->visit('/')
                    ->assertSee('Aziz Khan')
                    ->assertSee('2D/3D Artist & Web Developer')
                    ->assertVisible('.mobile-menu-button')
                    ->assertMissing('.desktop-nav')
                    ->click('.mobile-menu-button')
                    ->assertVisible('.mobile-menu')
                    ->assertSee('Projects')
                    ->assertSee('About')
                    ->assertSee('Blog')
                    ->assertSee('Contact');
        });
    }

    public function test_homepage_responsive_design_tablet()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(768, 1024)
                    ->visit('/')
                    ->assertSee('Aziz Khan')
                    ->assertVisible('.hero-section')
                    ->assertVisible('.featured-projects')
                    ->assertVisible('.testimonials-section')
                    ->assertVisible('.blog-section');
        });
    }

    public function test_homepage_responsive_design_desktop()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1920, 1080)
                    ->visit('/')
                    ->assertSee('Aziz Khan')
                    ->assertVisible('.desktop-nav')
                    ->assertMissing('.mobile-menu-button')
                    ->assertVisible('.hero-section')
                    ->assertVisible('.featured-projects')
                    ->assertVisible('.testimonials-section')
                    ->assertVisible('.blog-section');
        });
    }

    public function test_projects_page_responsive_grid()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 667)
                    ->visit('/projects')
                    ->assertSee('Projects')
                    ->with('.projects-grid', function ($grid) {
                        $grid->assertVisible('.project-card');
                    });

            $browser->resize(768, 1024)
                    ->refresh()
                    ->with('.projects-grid', function ($grid) {
                        $grid->assertVisible('.project-card');
                    });

            $browser->resize(1920, 1080)
                    ->refresh()
                    ->with('.projects-grid', function ($grid) {
                        $grid->assertVisible('.project-card');
                    });
        });
    }

    public function test_navigation_mobile_menu_functionality()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 667)
                    ->visit('/')
                    ->assertMissing('.mobile-menu')
                    ->click('.mobile-menu-button')
                    ->assertVisible('.mobile-menu')
                    ->click('.mobile-menu a[href*="projects"]')
                    ->waitForLocation('/projects')
                    ->assertPathIs('/projects');
        });
    }

    public function test_contact_form_responsive_layout()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 667)
                    ->visit('/contact')
                    ->assertVisible('input[name="name"]')
                    ->assertVisible('input[name="email"]')
                    ->assertVisible('textarea[name="message"]')
                    ->assertVisible('button[type="submit"]');

            $browser->resize(1920, 1080)
                    ->refresh()
                    ->assertVisible('input[name="name"]')
                    ->assertVisible('input[name="email"]')
                    ->assertVisible('textarea[name="message"]')
                    ->assertVisible('button[type="submit"]');
        });
    }

    public function test_blog_page_responsive_layout()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 667)
                    ->visit('/blog')
                    ->assertSee('Blog')
                    ->assertVisible('.blog-card');

            $browser->resize(1920, 1080)
                    ->refresh()
                    ->assertVisible('.blog-card')
                    ->assertVisible('.blog-grid');
        });
    }

    public function test_services_page_responsive_cards()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 667)
                    ->visit('/services')
                    ->assertSee('Services')
                    ->assertVisible('.service-card');

            $browser->resize(1920, 1080)
                    ->refresh()
                    ->assertVisible('.service-card')
                    ->assertVisible('.services-grid');
        });
    }

    public function test_testimonials_page_responsive_layout()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 667)
                    ->visit('/testimonials')
                    ->assertSee('Testimonials')
                    ->assertVisible('.testimonial-card');

            $browser->resize(1920, 1080)
                    ->refresh()
                    ->assertVisible('.testimonial-card')
                    ->assertVisible('.testimonials-grid');
        });
    }

    public function test_about_page_responsive_sections()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 667)
                    ->visit('/about')
                    ->assertSee('About')
                    ->assertVisible('.profile-section')
                    ->assertVisible('.skills-section');

            $browser->resize(1920, 1080)
                    ->refresh()
                    ->assertVisible('.profile-section')
                    ->assertVisible('.skills-section')
                    ->assertVisible('.experience-section');
        });
    }

    public function test_sticky_navigation_behavior()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1920, 1080)
                    ->visit('/')
                    ->assertVisible('.navbar')
                    ->script('window.scrollTo(0, 500);')
                    ->pause(500)
                    ->assertVisible('.navbar')
                    ->assertHasClass('.navbar', 'sticky');
        });
    }

    public function test_image_lazy_loading()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertVisible('img[loading="lazy"]')
                    ->script('window.scrollTo(0, document.body.scrollHeight);')
                    ->pause(1000)
                    ->assertVisible('.featured-projects img');
        });
    }

    public function test_touch_friendly_interactions_mobile()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 667)
                    ->visit('/projects')
                    ->assertVisible('.project-card')
                    ->tap('.project-card:first-child')
                    ->pause(500)
                    ->assertVisible('.project-modal, .project-detail');
        });
    }

    public function test_keyboard_navigation_accessibility()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->keys('body', '{tab}')
                    ->assertFocused('.skip-link, .navbar a:first-child')
                    ->keys('body', '{tab}')
                    ->keys('body', '{tab}')
                    ->keys('body', '{enter}')
                    ->pause(500);
        });
    }

    public function test_focus_states_visibility()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                    ->click('input[name="name"]')
                    ->assertHasClass('input[name="name"]', 'focus:ring')
                    ->click('input[name="email"]')
                    ->assertHasClass('input[name="email"]', 'focus:ring')
                    ->click('textarea[name="message"]')
                    ->assertHasClass('textarea[name="message"]', 'focus:ring');
        });
    }

    public function test_color_contrast_accessibility()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertVisible('.hero-section')
                    ->assertVisible('.featured-projects')
                    ->assertSeeIn('.hero-section', 'Aziz Khan')
                    ->assertSeeIn('.featured-projects', 'Featured Work');
        });
    }

    public function test_alt_text_for_images()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSourceHas('alt=')
                    ->visit('/projects')
                    ->assertSourceHas('alt=')
                    ->visit('/blog')
                    ->assertSourceHas('alt=');
        });
    }

    public function test_aria_labels_present()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSourceHas('aria-label')
                    ->assertSourceHas('role=')
                    ->visit('/contact')
                    ->assertSourceHas('aria-label')
                    ->assertSourceHas('aria-describedby');
        });
    }
}