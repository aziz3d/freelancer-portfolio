<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\Content;
use App\Services\SEOService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index()
    {
        $featuredWorkSection = Content::where('key', 'featured_work_section')->first();
        $servicesSection = Content::where('key', 'services_section')->first();
        $latestArticlesSection = Content::where('key', 'latest_articles_section')->first();
        $testimonialsSection = Content::where('key', 'testimonials_section')->first();

        $featuredProjects = collect();
        if (!$featuredWorkSection || ($featuredWorkSection->meta['is_visible'] ?? true)) {
            $featuredProjects = Project::featuredPublished(6)->get();
        }
        
        $recentBlogs = collect();
        if (!$latestArticlesSection || ($latestArticlesSection->meta['is_visible'] ?? true)) {
            $recentBlogs = Blog::recent(3)->get();
        }
        
        $featuredTestimonials = collect();
        if (!$testimonialsSection || ($testimonialsSection->meta['is_visible'] ?? true)) {
            $featuredTestimonials = Testimonial::featured()
                ->ordered()
                ->limit(3)
                ->get();
        }
        
        $featuredServices = collect();
        if (!$servicesSection || ($servicesSection->meta['is_visible'] ?? true)) {
            $featuredServices = Service::active()
                ->ordered()
                ->limit(6)
                ->get();
        }
        
        $projectStats = [
            'total_projects' => Project::published()->count(),
            'years_experience' => 5,
            'client_satisfaction' => 100,
        ];

        $heroContent = Content::where('key', 'hero')->first();
        $defaultHero = [
            'title' => 'Hi, I\'m Aziz Khan',
            'content' => 'I create digital experiences that blend creativity with functionality, specializing in Laravel development, 3D modeling, and UI/UX design.',
            'meta' => [
                'subtitle' => '2D/3D Artist & Web Developer',
                'cta_text' => 'View Projects',
                'cta_url' => route('projects.index')
            ]
        ];
        
        $footerContent = Content::where('key', 'footer')->first();
        $defaultFooter = [
            'title' => 'Aziz Khan',
            'content' => '2D/3D Artist & Web Developer passionate about creating digital experiences that blend creativity with functionality. Specializing in Laravel development, 3D modeling, and UI/UX design.',
            'meta' => [
                'copyright' => '© ' . date('Y') . ' Aziz Khan. All rights reserved.',
                'email' => 'contact@azizkhan.dev'
            ]
        ];

        $seoData = $this->seoService->generateMetaTags('home');

        return view('pages.home', compact(
            'featuredProjects',
            'recentBlogs', 
            'featuredTestimonials',
            'featuredServices',
            'projectStats',
            'seoData'
        ))->with([
            'hero' => $heroContent ? $heroContent->toArray() : $defaultHero,
            'footer' => $footerContent ? $footerContent->toArray() : $defaultFooter,
            'featuredWorkSection' => $featuredWorkSection,
            'servicesSection' => $servicesSection,
            'latestArticlesSection' => $latestArticlesSection,
            'testimonialsSection' => $testimonialsSection
        ]);
    }
}