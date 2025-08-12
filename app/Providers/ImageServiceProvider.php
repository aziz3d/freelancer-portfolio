<?php

namespace App\Providers;

use App\Services\ImageService;
use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
 
    public function register(): void
    {
        $this->app->singleton(ImageService::class, function ($app) {
            return new ImageService();
        });
    }

  
    public function boot(): void
    {
        
        $directories = [
            'projects',
            'projects/thumbs',
            'blog',
            'blog/thumbs',
            'testimonials',
            'testimonials/thumbs',
            'general',
            'general/thumbs'
        ];

        foreach ($directories as $directory) {
            $path = public_path('images/' . $directory);
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }
    }
}
