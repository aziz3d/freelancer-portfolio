<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Content;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

 
    public function boot(): void
    {
        
        View::composer('*', function ($view) {
            
            $footerContent = Content::where('key', 'footer')->first();
            $defaultFooter = [
                'title' => 'Aziz Khan',
                'content' => '2D/3D Artist & Web Developer passionate about creating digital experiences that blend creativity with functionality. Specializing in Laravel development, 3D modeling, and UI/UX design.',
                'meta' => [
                    'copyright' => '© ' . date('Y') . ' Aziz Khan. All rights reserved.',
                    'email' => ''
                ]
            ];
            
            
            $contactInfo = Content::where('key', 'contact_info')->first();
            $contactSocial = Content::where('key', 'contact_social')->first();
            $contactRecaptcha = Content::where('key', 'contact_recaptcha')->first();
            
            
            $siteBranding = Content::where('key', 'site_branding')->first();
            
            $defaultContactInfo = [
                'title' => 'Contact Information',
                'meta' => [
                    'email' => '',
                    'location' => 'Available for remote work',
                    'response_time' => 'Usually within 24 hours',
                    'availability' => 'available'
                ]
            ];
            
            $defaultContactSocial = [
                'title' => 'Connect With Me',
                'content' => 'Let\'s connect on social media and professional networks',
                'meta' => [
                    'social_links' => []
                ]
            ];
            
            $defaultContactRecaptcha = [
                'title' => 'Google reCAPTCHA Settings',
                'meta' => [
                    'enabled' => false,
                    'site_key' => '',
                    'secret_key' => '',
                    'version' => 'v2',
                    'threshold' => '0.5'
                ]
            ];
            
            $defaultSiteBranding = [
                'title' => 'Aziz Khan',
                'content' => 'Professional portfolio and web development services',
                'meta' => [
                    'logo' => null,
                    'favicon' => null,
                    'brand_color' => '#3B82F6',
                    'logo_alt' => 'Site Logo',
                    'meta_keywords' => 'web developer, designer, portfolio',
                    'meta_author' => 'Aziz Khan'
                ]
            ];
            
            
            $siteBrandingData = $siteBranding ? $siteBranding->toArray() : $defaultSiteBranding;

            
            if (!isset($siteBrandingData['meta']) || !is_array($siteBrandingData['meta'])) {
                $siteBrandingData['meta'] = $defaultSiteBranding['meta'];
            } else {
                
                $siteBrandingData['meta'] = array_merge($defaultSiteBranding['meta'], $siteBrandingData['meta']);
            }

            $view->with([
                'footer' => $footerContent ? $footerContent->toArray() : $defaultFooter,
                'contactInfo' => $contactInfo ? $contactInfo->toArray() : $defaultContactInfo,
                'contactSocial' => $contactSocial ? $contactSocial->toArray() : $defaultContactSocial,
                'contactRecaptcha' => $contactRecaptcha ? $contactRecaptcha->toArray() : $defaultContactRecaptcha,
                'siteBranding' => $siteBrandingData
            ]);
        });
    }
}
