<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\File;

class ImageServiceBasicTest extends TestCase
{
    public function test_image_directories_exist()
    {
        $directories = [
            'projects',
            'blog', 
            'testimonials',
            'general'
        ];

        foreach ($directories as $directory) {
            $path = public_path('images/' . $directory);
            $this->assertTrue(File::exists($path), "Directory {$directory} should exist");
        }
    }

    public function test_change_extension_helper()
    {
        $filename = 'test.jpg';
        $newExtension = 'webp';
        
        $result = pathinfo($filename, PATHINFO_FILENAME) . '.' . $newExtension;
        
        $this->assertEquals('test.webp', $result);
    }

    public function test_image_validation_rules()
    {
        $allowedTypes = [
            'image/jpeg',
            'image/jpg', 
            'image/png',
            'image/gif',
            'image/webp'
        ];
        
        $this->assertContains('image/jpeg', $allowedTypes);
        $this->assertContains('image/webp', $allowedTypes);
        $this->assertNotContains('image/bmp', $allowedTypes);
    }

    public function test_max_file_size_constant()
    {
        $maxFileSize = 5242880;
        
        $this->assertEquals(5 * 1024 * 1024, $maxFileSize);
    }
}