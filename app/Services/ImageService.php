<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageService
{
    protected ?ImageManager $manager;
    protected array $allowedMimeTypes = [
        'image/jpeg',
        'image/jpg', 
        'image/png',
        'image/gif',
        'image/webp'
    ];
    
    protected int $maxFileSize = 5242880;
    protected int $thumbnailWidth = 400;
    protected int $thumbnailHeight = 300;
    protected int $jpegQuality = 85;
    protected int $webpQuality = 80;

    public function __construct()
    {
        
        if (extension_loaded('gd') && function_exists('gd_info')) {
            $this->manager = new ImageManager(new Driver());
        } else {
            
            \Log::warning('GD extension not available. Image processing will be limited.');
            $this->manager = null;
        }
    }

    
    public function uploadImage(UploadedFile $file, string $directory = 'general', array $sizes = []): array
    {
        $this->validateImage($file);
        
        $filename = $this->generateFilename($file);
        $directory = $this->ensureDirectoryExists($directory);
        
        $paths = [];
        
        
        $originalPath = $directory . '/' . $filename;
        
        if ($this->manager) {
            
            $image = $this->manager->read($file->getPathname());
            
            
            $image = $this->optimizeImage($image);
            $image->save(public_path('images/' . $originalPath));
            $paths['original'] = $originalPath;
            
            
            $webpPath = $directory . '/' . $this->changeExtension($filename, 'webp');
            $image->toWebp($this->webpQuality)->save(public_path('images/' . $webpPath));
            $paths['webp'] = $webpPath;
            
            
            $thumbnailPath = $directory . '/thumbs/' . $filename;
            $this->ensureDirectoryExists($directory . '/thumbs');
            $thumbnail = $this->createThumbnail($image);
            $thumbnail->save(public_path('images/' . $thumbnailPath));
            $paths['thumbnail'] = $thumbnailPath;
            
            
            $webpThumbnailPath = $directory . '/thumbs/' . $this->changeExtension($filename, 'webp');
            $thumbnail->toWebp($this->webpQuality)->save(public_path('images/' . $webpThumbnailPath));
            $paths['thumbnail_webp'] = $webpThumbnailPath;
            
            
            foreach ($sizes as $sizeName => $dimensions) {
                $customPath = $directory . '/' . $sizeName . '/' . $filename;
                $this->ensureDirectoryExists($directory . '/' . $sizeName);
                
                $customImage = $this->resizeImage($image, $dimensions['width'], $dimensions['height']);
                $customImage->save(public_path('images/' . $customPath));
                $paths[$sizeName] = $customPath;
                
                
                $customWebpPath = $directory . '/' . $sizeName . '/' . $this->changeExtension($filename, 'webp');
                $customImage->toWebp($this->webpQuality)->save(public_path('images/' . $customWebpPath));
                $paths[$sizeName . '_webp'] = $customWebpPath;
            }
        } else {
            
            $file->move(public_path('images/' . $directory), $filename);
            $paths['original'] = $originalPath;
            
            
            $this->ensureDirectoryExists($directory . '/thumbs');
            $paths['thumbnail'] = $originalPath;
        }
        
        return $paths;
    }

  
    protected function validateImage(UploadedFile $file): void
    {
        if (!$file->isValid()) {
            throw new \InvalidArgumentException('Invalid file upload');
        }
        
        if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
            throw new \InvalidArgumentException('Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.');
        }
        
        if ($file->getSize() > $this->maxFileSize) {
            throw new \InvalidArgumentException('File size too large. Maximum size is 5MB.');
        }
    }

    
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $timestamp = time();
        $random = Str::random(8);
        
        return "{$name}_{$timestamp}_{$random}.{$extension}";
    }

  
    protected function ensureDirectoryExists(string $directory): string
    {
        $fullPath = public_path('images/' . $directory);
        
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
        
        return $directory;
    }

    
    protected function optimizeImage($image)
    {
        
        if ($image->width() > 1920 || $image->height() > 1080) {
            $image->scaleDown(width: 1920, height: 1080);
        }
        
        return $image;
    }

    
    protected function createThumbnail($image)
    {
        return $image->cover($this->thumbnailWidth, $this->thumbnailHeight);
    }

   
    protected function resizeImage($image, int $width, int $height)
    {
        return $image->cover($width, $height);
    }

    
    protected function changeExtension(string $filename, string $newExtension): string
    {
        return pathinfo($filename, PATHINFO_FILENAME) . '.' . $newExtension;
    }

   
    public function deleteImage(string $imagePath): bool
    {
        $deleted = true;
        
        
        if (File::exists(public_path('images/' . $imagePath))) {
            $deleted = File::delete(public_path('images/' . $imagePath)) && $deleted;
        }
        
        
        $webpPath = $this->changeExtension($imagePath, 'webp');
        if (File::exists(public_path('images/' . $webpPath))) {
            $deleted = File::delete(public_path('images/' . $webpPath)) && $deleted;
        }
        
       
        $directory = dirname($imagePath);
        $filename = basename($imagePath);
        $thumbnailPath = $directory . '/thumbs/' . $filename;
        $thumbnailWebpPath = $directory . '/thumbs/' . $this->changeExtension($filename, 'webp');
        
        if (File::exists(public_path('images/' . $thumbnailPath))) {
            $deleted = File::delete(public_path('images/' . $thumbnailPath)) && $deleted;
        }
        
        if (File::exists(public_path('images/' . $thumbnailWebpPath))) {
            $deleted = File::delete(public_path('images/' . $thumbnailWebpPath)) && $deleted;
        }
        
        return $deleted;
    }

    
    public function getImageUrl(string $imagePath, bool $preferWebp = true): array
    {
       
        $fullPath = str_contains($imagePath, '/') ? $imagePath : $imagePath;
        
        $urls = [
            'original' => asset($fullPath),
        ];
        
        if ($preferWebp) {
            $webpPath = $this->changeExtension($fullPath, 'webp');
            if (File::exists(public_path($webpPath))) {
                $urls['webp'] = asset($webpPath);
            }
        }
        
        return $urls;
    }

    
    public function getThumbnailUrl(string $imagePath, bool $preferWebp = true): array
    {
        
        if (str_contains($imagePath, '/')) {
            
            $directory = dirname($imagePath);
            $filename = basename($imagePath);
            $thumbnailPath = $directory . '/thumbs/' . $filename;
            $fullThumbnailPath = $thumbnailPath;
        } else {
            
            $thumbnailPath = 'thumbs/' . $imagePath;
            $fullThumbnailPath = 'images/' . $thumbnailPath;
        }
        
        $urls = [
            'original' => str_contains($imagePath, '/') ? asset($imagePath) : asset('images/' . $imagePath),
        ];
        
        
        if (File::exists(public_path($fullThumbnailPath))) {
            $urls['original'] = asset($fullThumbnailPath);
            
            if ($preferWebp) {
                $webpThumbnailPath = $this->changeExtension($fullThumbnailPath, 'webp');
                if (File::exists(public_path($webpThumbnailPath))) {
                    $urls['webp'] = asset($webpThumbnailPath);
                }
            }
        }
        
        return $urls;
    }
}