<?php

namespace Tests\Unit;

use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    protected ImageService $imageService;
    protected string $testImagePath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->imageService = new ImageService();
        
        $this->testImagePath = public_path('images/test');
        if (!File::exists($this->testImagePath)) {
            File::makeDirectory($this->testImagePath, 0755, true);
        }
    }

    protected function tearDown(): void
    {
        if (File::exists($this->testImagePath)) {
            File::deleteDirectory($this->testImagePath);
        }
        
        parent::tearDown();
    }

    public function test_can_validate_valid_image()
    {
        if (!extension_loaded('gd')) {
            $this->markTestSkipped('GD extension not available');
        }
        
        $file = UploadedFile::fake()->image('test.jpg', 800, 600)->size(1000);
        
        $reflection = new \ReflectionClass($this->imageService);
        $method = $reflection->getMethod('validateImage');
        $method->setAccessible(true);
        
        $this->expectNotToPerformAssertions();
        $method->invoke($this->imageService, $file);
    }

    public function test_rejects_invalid_file_type()
    {
        $file = UploadedFile::fake()->create('test.txt', 1000, 'text/plain');
        
        $reflection = new \ReflectionClass($this->imageService);
        $method = $reflection->getMethod('validateImage');
        $method->setAccessible(true);
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid file type');
        
        $method->invoke($this->imageService, $file);
    }

    public function test_rejects_oversized_file()
    {
        $file = UploadedFile::fake()->image('test.jpg', 800, 600)->size(6000); // 6MB
        
        $reflection = new \ReflectionClass($this->imageService);
        $method = $reflection->getMethod('validateImage');
        $method->setAccessible(true);
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File size too large');
        
        $method->invoke($this->imageService, $file);
    }

    public function test_generates_unique_filename()
    {
        $file = UploadedFile::fake()->image('test image.jpg', 800, 600);
        
        $reflection = new \ReflectionClass($this->imageService);
        $method = $reflection->getMethod('generateFilename');
        $method->setAccessible(true);
        
        $filename1 = $method->invoke($this->imageService, $file);
        $filename2 = $method->invoke($this->imageService, $file);
        
        $this->assertNotEquals($filename1, $filename2);
        $this->assertStringContains('test-image', $filename1);
        $this->assertStringEndsWith('.jpg', $filename1);
    }

    public function test_changes_file_extension()
    {
        $reflection = new \ReflectionClass($this->imageService);
        $method = $reflection->getMethod('changeExtension');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->imageService, 'test.jpg', 'webp');
        
        $this->assertEquals('test.webp', $result);
    }

    public function test_ensures_directory_exists()
    {
        $testDir = 'test-directory';
        $fullPath = public_path('images/' . $testDir);
        
        if (File::exists($fullPath)) {
            File::deleteDirectory($fullPath);
        }
        
        $reflection = new \ReflectionClass($this->imageService);
        $method = $reflection->getMethod('ensureDirectoryExists');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->imageService, $testDir);
        
        $this->assertEquals($testDir, $result);
        $this->assertTrue(File::exists($fullPath));
        
        File::deleteDirectory($fullPath);
    }

    public function test_get_image_url_returns_correct_format()
    {
        $imagePath = 'projects/test.jpg';
        $urls = $this->imageService->getImageUrl($imagePath);
        
        $this->assertArrayHasKey('original', $urls);
        $this->assertStringContains('images/projects/test.jpg', $urls['original']);
    }

    public function test_get_thumbnail_url_returns_correct_format()
    {
        $imagePath = 'projects/test.jpg';
        $urls = $this->imageService->getThumbnailUrl($imagePath);
        
        $this->assertArrayHasKey('original', $urls);
        $this->assertStringContains('images/projects/thumbs/test.jpg', $urls['original']);
    }
}