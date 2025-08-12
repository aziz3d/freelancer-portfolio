<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Content;

class DashboardController extends Controller
{
    public function index()
    {
        
        $aboutSections = [
            'about_profile_summary',
            'about_skills',
            'about_experience',
            'about_education',
            'about_certifications',
            'about_personal_info',
            'about_resume',
            'about_social_links',
            'about_achievements',
            'about_hobbies'
        ];
        
        $aboutContentCount = Content::whereIn('key', $aboutSections)->count();

        $stats = [
            'projects' => Project::count(),
            'published_projects' => Project::where('status', 'published')->count(),
            'blogs' => Blog::count(),
            'published_blogs' => Blog::where('status', 'published')->count(),
            'services' => Service::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'testimonials' => Testimonial::count(),
            'featured_testimonials' => Testimonial::where('is_featured', true)->count(),
            'contacts' => Contact::count(),
            'unread_contacts' => Contact::where('status', 'new')->count(),
            'about_sections_total' => count($aboutSections),
            'about_sections_configured' => $aboutContentCount,
        ];

        $recent_contacts = Contact::latest()->take(5)->get();
        $recent_projects = Project::latest()->take(5)->get();
        $recent_blogs = Blog::latest()->take(5)->get();
        
        
        $recent_about_updates = Content::whereIn('key', $aboutSections)
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_contacts', 'recent_projects', 'recent_blogs', 'recent_about_updates'));
    }
}