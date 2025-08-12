<?php

namespace Tests\Unit\Services;

use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    protected $imageService;
    protected $testImagePath;

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

    public function test_validates_image_file_type()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid file type');

        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        $this->imageService->uploadImage($file, 'test');
    }

    public function test_validates_image_file_size()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('File size too large');

        $file = UploadedFile::fake()->create('large-image.jpg', 6000, 'image/jpeg');
        $this->imageService->uploadImage($file, 'test');
    }

    public function test_validates_invalid_file_upload()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid file upload');

        $file = UploadedFile::fake()->create('invalid.jpg', 0, 'image/jpeg');
        $file = new UploadedFile('', '', null, UPLOAD_ERR_NO_FILE, true);
        
        $this->imageService->uploadImage($file, 'test');
    }

    public function test_generates_unique_filename()
    {
        $file1 = UploadedFile::fake()->image('test.jpg', 100, 100);
        $file2 = UploadedFile::fake()->image('test.jpg', 100, 100);

        $result1 = $this->imageService->uploadImage($file1, 'test');
        $result2 = $this->imageService->uploadImage($file2, 'test');

        $this->assertNotEquals($result1['original'], $result2['original']);
    }

    public function test_creates_directory_if_not_exists()
    {
        $file = UploadedFile::fake()->image('test.jpg', 100, 100);
        $newDirectory = 'test/new-directory';

        $this->imageService->uploadImage($file, $newDirectory);

        $this->assertTrue(File::exists(public_path('images/' . $newDirectory)));
    }

    public function test_upload_image_returns_correct_paths()
    {
        $file = UploadedFile::fake()->image('test.jpg', 100, 100);
        
        $result = $this->imageService->uploadImage($file, 'test');

        $this->assertArrayHasKey('original', $result);
        $this->assertArrayHasKey('thumbnail', $result);
        
        if (extension_loaded('gd')) {
            $this->assertArrayHasKey('webp', $result);
            $this->assertArrayHasKey('thumbnail_webp', $result);
        }
    }

    public function test_upload_image_with_custom_sizes()
    {
        $file = UploadedFile::fake()->image('test.jpg', 500, 500);
        $customSizes = [
            'medium' => ['width' => 300, 'height' => 300],
            'small' => ['width' => 150, 'height' => 150]
        ];

        $result = $this->imageService->uploadImage($file, 'test', $customSizes);

        $this->assertArrayHasKey('original', $result);
        $this->assertArrayHasKey('thumbnail', $result);
        
        if (extension_loaded('gd')) {
            $this->assertArrayHasKey('medium', $result);
            $this->assertArrayHasKey('small', $result);
            $this->assertArrayHasKey('medium_webp', $result);
            $this->assertArrayHasKey('small_webp', $result);
        }
    }

    public function test_get_image_url_returns_correct_format()
    {
        $imagePath = 'test/sample-image.jpg';
        
        $urls = $this->imageService->getImageUrl($imagePath);

        $this->assertArrayHasKey('original', $urls);
        $this->assertStringContainsString('images/test/sample-image.jpg', $urls['original']);
    }

    public function test_get_image_url_with_webp_preference()
    {
        $imagePath = 'test/sample-image.jpg';
        
        $webpPath = public_path('images/test/sample-image.webp');
        File::put($webpPath, 'fake webp content');

        $urls = $this->imageService->getImageUrl($imagePath, true);

        $this->assertArrayHasKey('original', $urls);
        $this->assertArrayHasKey('webp', $urls);
        $this->assertStringContainsString('sample-image.webp', $urls['webp']);

        File::delete($webpPath);
    }

    public function test_get_thumbnail_url_returns_correct_format()
    {
        $imagePath = 'test/sample-image.jpg';
        
        $urls = $this->imageService->getThumbnailUrl($imagePath);

        $this->assertArrayHasKey('original', $urls);
        $this->assertStringContainsString('images/test/thumbs/sample-image.jpg', $urls['original']);
    }

    public function test_get_thumbnail_url_with_webp_preference()
    {
        $imagePath = 'test/sample-image.jpg';
        
        $thumbDir = public_path('images/test/thumbs');
        File::makeDirectory($thumbDir, 0755, true);
        $webpPath = $thumbDir . '/sample-image.webp';
        File::put($webpPath, 'fake webp content');

        $urls = $this->imageService->getThumbnailUrl($imagePath, true);

        $this->assertArrayHasKey('original', $urls);
        $this->assertArrayHasKey('webp', $urls);
        $this->assertStringContainsString('thumbs/sample-image.webp', $urls['webp']);

        File::deleteDirectory($thumbDir);
    }

    public function test_delete_image_removes_all_variants()
    {
        $imagePath = 'test/sample-image.jpg';
        
        $originalPath = public_path('images/' . $imagePath);
        $webpPath = public_path('images/test/sample-image.webp');
        $thumbDir = public_path('images/test/thumbs');
        $thumbnailPath = $thumbDir . '/sample-image.jpg';
        $thumbnailWebpPath = $thumbDir . '/sample-image.webp';

        File::makeDirectory($thumbDir, 0755, true);
        File::put($originalPath, 'fake image content');
        File::put($webpPath, 'fake webp content');
        File::put($thumbnailPath, 'fake thumbnail content');
        File::put($thumbnailWebpPath, 'fake thumbnail webp content');

        $result = $this->imageService->deleteImage($imagePath);

        $this->assertTrue($result);
        $this->assertFalse(File::exists($originalPath));
        $this->assertFalse(File::exists($webpPath));
        $this->assertFalse(File::exists($thumbnailPath));
        $this->assertFalse(File::exists($thumbnailWebpPath));
    }

    public function test_delete_image_handles_missing_files_gracefully()
    {
        $imagePath = 'test/nonexistent-image.jpg';
        
        $result = $this->imageService->deleteImage($imagePath);

        $this->assertTrue($result);
    }

    public function test_handles_gd_extension_not_available()
    {
        $service = new ImageService();
        $this->assertInstanceOf(ImageService::class, $service);
    }

    public function test_accepts_valid_image_mime_types()
    {
        $validTypes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
        
        foreach ($validTypes as $type) {
            $file = UploadedFile::fake()->image("test.{$type}", 100, 100);
            
            try {
                $result = $this->imageService->uploadImage($file, 'test');
                $this->assertIsArray($result);
                $this->assertArrayHasKey('original', $result);
            } catch (\Exception $e) {
                $this->fail("Valid image type {$type} should not throw exception: " . $e->getMessage());
            }
        }
    }

    public function test_filename_generation_includes_timestamp_and_random()
    {
        $file = UploadedFile::fake()->image('My Test Image!.jpg', 100, 100);
        
        $result = $this->imageService->uploadImage($file, 'test');
        $filename = basename($result['original']);

        $this->assertStringContainsString('my-test-image', $filename);
        $this->assertMatchesRegularExpression('/my-test-image_\d+_[a-zA-Z0-9]{8}\.jpg/', $filename);
    }

    public function test_change_extension_method()
    {
        $reflection = new \ReflectionClass($this->imageService);
        $method = $reflection->getMethod('changeExtension');
        $method->setAccessible(true);

        $result = $method->invoke($this->imageService, 'test-image.jpg', 'webp');
        $this->assertEquals('test-image.webp', $result);

        $result = $method->invoke($this->imageService, 'complex.file.name.png', 'gif');
        $this->assertEquals('complex.file.name.gif', $result);
    }
}