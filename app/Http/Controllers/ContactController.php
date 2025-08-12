<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use App\Models\Content;
use App\Services\SEOService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    protected $seoService;

    public function __construct(SEOService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index()
    {
        $pageTitleSettings = Content::byKey('page_titles_contact')->first();
        $defaultPageTitle = [
            'title' => 'Get In Touch',
            'content' => 'Have a project in mind? I\'d love to hear from you. Send me a message and I\'ll respond as soon as possible.',
            'meta' => ['subtitle' => '']
        ];

        $seoData = $this->seoService->generateMetaTags('contact');

        return view('pages.contact', compact('seoData'))->with([
            'pageTitle' => $pageTitleSettings ? $pageTitleSettings->toArray() : $defaultPageTitle
        ]);
    }

    public function store(ContactFormRequest $request)
    {
        try {
            $recaptchaSettings = Content::where('key', 'contact_recaptcha')->first();
            
            if ($recaptchaSettings && 
                isset($recaptchaSettings->meta['enabled']) && 
                $recaptchaSettings->meta['enabled']) {
                
                $recaptchaResponse = $request->input('g-recaptcha-response');
                
                if (!$recaptchaResponse) {
                    return back()
                        ->withInput()
                        ->with('error', 'Please complete the reCAPTCHA verification.');
                }
                
                $secretKey = $recaptchaSettings->meta['secret_key'] ?? '';
                $version = $recaptchaSettings->meta['version'] ?? 'v2';
                
                if ($secretKey) {
                    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                        'secret' => $secretKey,
                        'response' => $recaptchaResponse,
                        'remoteip' => $request->ip()
                    ]);
                    
                    $result = $response->json();
                    
                    if (!$result['success']) {
                        return back()
                            ->withInput()
                            ->with('error', 'reCAPTCHA verification failed. Please try again.');
                    }
                    
                    if ($version === 'v3' && isset($result['score'])) {
                        $threshold = floatval($recaptchaSettings->meta['threshold'] ?? 0.5);
                        if ($result['score'] < $threshold) {
                            return back()
                                ->withInput()
                                ->with('error', 'Security verification failed. Please try again.');
                        }
                    }
                }
            }

            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject ?? 'Contact Form Submission',
                'message' => $request->message,
                'status' => 'new'
            ]);


            return back()->with('success', 'Thank you for your message! I\'ll get back to you soon.');
            
        } catch (\Exception $e) {
            \Log::error('Contact form submission failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Sorry, there was an error sending your message. Please try again.');
        }
    }
}