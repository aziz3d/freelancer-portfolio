<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Services\SEOService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index()
    {
        $testimonials = Testimonial::ordered()
            ->get();

        $seoData = $this->seoService->generateMetaTags('testimonials');

        return view('pages.testimonials', compact('testimonials', 'seoData'));
    }
}