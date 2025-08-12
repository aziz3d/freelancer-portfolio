<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Content;
use App\Services\SEOService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index()
    {
        $pageTitleSettings = Content::byKey('page_titles_services')->first();
        $defaultPageTitle = [
            'title' => 'Professional Services',
            'content' => 'Comprehensive solutions for your digital and creative needs. From web development to 3D artistry, I deliver high-quality work that brings your vision to life.',
            'meta' => ['subtitle' => '']
        ];

        $services = Service::active()
            ->ordered()
            ->get();

        $servicesCta = Content::where('key', 'services_cta')->first();
        $defaultCta = [
            'title' => 'Ready to Start Your Project?',
            'content' => "Let's discuss how I can help bring your vision to life with professional, high-quality work tailored to your specific needs.",
            'meta' => [
                'primary_button_text' => 'Get In Touch',
                'primary_button_url' => route('contact'),
                'secondary_button_text' => 'View My Work',
                'secondary_button_url' => route('projects.index')
            ]
        ];

        $seoData = $this->seoService->generateMetaTags('services');

        return view('pages.services', compact('services', 'seoData'))->with([
            'pageTitle' => $pageTitleSettings ? $pageTitleSettings->toArray() : $defaultPageTitle,
            'servicesCta' => $servicesCta ? $servicesCta->toArray() : $defaultCta
        ]);
    }
}