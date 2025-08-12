<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;

// Tese are Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/resume/download', [AboutController::class, 'downloadResume'])->name('resume.download');
Route::get('/debug/resume', [AboutController::class, 'debugResume'])->name('debug.resume');
Route::get('/create-default-resume', [AboutController::class, 'createDefaultResume'])->name('create.default.resume');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/services', [ServiceController::class, 'index'])->name('services');

Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// These are SEO Routes
use App\Http\Controllers\SEOController;
Route::get('/sitemap.xml', [SEOController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SEOController::class, 'robots'])->name('robots');

// These are Admin Routes
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

Route::prefix('admin')->name('admin.')->group(function () {
    // These are Authentication Routes But Not Protected
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // These are Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    // These Protected Admin Routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.alt');
        
        // These Profile Management Routes
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile/photo', [AdminProfileController::class, 'removePhoto'])->name('profile.remove-photo');
        
        // These are Projects Management Routes
        Route::resource('projects', AdminProjectController::class);
        Route::post('/projects/bulk-action', [AdminProjectController::class, 'bulkAction'])->name('projects.bulk-action');
        
        // These are Blog Management Routes
        Route::resource('blog', AdminBlogController::class);
        Route::post('/blog/bulk-action', [AdminBlogController::class, 'bulkAction'])->name('blog.bulk-action');
        
        // These are Services Management Routes
        Route::resource('services', AdminServiceController::class);
        Route::post('/services/bulk-action', [AdminServiceController::class, 'bulkAction'])->name('services.bulk-action');
        
        // These are Content Management Routes
        Route::get('/content', [AdminContentController::class, 'index'])->name('content.index');
        Route::get('/content/{key}/edit', [AdminContentController::class, 'editContent'])->name('content.edit');
        Route::put('/content/{key}', [AdminContentController::class, 'updateContent'])->name('content.update');
        
        // These are Organized Settings Pages Routes
        Route::get('/content/general-settings', [AdminContentController::class, 'generalSettings'])->name('content.general-settings');
        Route::post('/content/general-bulk-update', [AdminContentController::class, 'bulkUpdateGeneral'])->name('content.general-bulk-update');
        
        Route::get('/content/branding-settings', [AdminContentController::class, 'brandingSettings'])->name('content.branding-settings');
        Route::post('/content/branding-bulk-update', [AdminContentController::class, 'bulkUpdateBranding'])->name('content.branding-bulk-update');
        
        Route::get('/content/about-settings', [AdminContentController::class, 'aboutSettings'])->name('content.about-settings');
        Route::post('/content/about-bulk-update', [AdminContentController::class, 'bulkUpdateAbout'])->name('content.about-bulk-update');
        
        Route::get('/content/contact-settings', [AdminContentController::class, 'contactSettings'])->name('content.contact-settings');
        Route::post('/content/contact-bulk-update', [AdminContentController::class, 'bulkUpdateContact'])->name('content.contact-bulk-update');
        
        Route::get('/content/services-settings', [AdminContentController::class, 'servicesSettings'])->name('content.services-settings');
        Route::post('/content/services-bulk-update', [AdminContentController::class, 'bulkUpdateServices'])->name('content.services-bulk-update');
        
        Route::get('/content/projects-settings', [AdminContentController::class, 'projectsSettings'])->name('content.projects-settings');
        Route::post('/content/projects-bulk-update', [AdminContentController::class, 'bulkUpdateProjects'])->name('content.projects-bulk-update');
        
        Route::get('/content/pages-title-settings', [AdminContentController::class, 'pagesTitleSettings'])->name('content.pages-title-settings');
        Route::post('/content/pages-title-bulk-update', [AdminContentController::class, 'bulkUpdatePagesTitle'])->name('content.pages-title-bulk-update');
        
        Route::get('/content/blog-settings', [AdminContentController::class, 'blogSettings'])->name('content.blog-settings');
        Route::post('/content/blog-bulk-update', [AdminContentController::class, 'bulkUpdateBlog'])->name('content.blog-bulk-update');
        
        Route::get('/content/testimonials-settings', [AdminContentController::class, 'testimonialsSettings'])->name('content.testimonials-settings');
        Route::post('/content/testimonials-bulk-update', [AdminContentController::class, 'bulkUpdateTestimonials'])->name('content.testimonials-bulk-update');
        
        // These are Testimonials Management Routes
        Route::get('/testimonials', [AdminContentController::class, 'testimonials'])->name('testimonials.index');
        Route::get('/testimonials/create', [AdminContentController::class, 'createTestimonial'])->name('testimonials.create');
        Route::post('/testimonials', [AdminContentController::class, 'storeTestimonial'])->name('testimonials.store');
        Route::get('/testimonials/{testimonial}/edit', [AdminContentController::class, 'editTestimonial'])->name('testimonials.edit');
        Route::put('/testimonials/{testimonial}', [AdminContentController::class, 'updateTestimonial'])->name('testimonials.update');
        Route::delete('/testimonials/{testimonial}', [AdminContentController::class, 'destroyTestimonial'])->name('testimonials.destroy');
        
        // These are Contacts Management Routes
        Route::get('/content/contacts', [AdminContentController::class, 'contacts'])->name('content.contacts');
        Route::post('/content/contacts/bulk-action', [AdminContentController::class, 'bulkContactAction'])->name('content.contacts.bulk-action');
        Route::get('/content/contacts/{contact}', [AdminContentController::class, 'showContact'])->name('content.contacts.show');
        Route::patch('/content/contacts/{contact}/status', [AdminContentController::class, 'updateContactStatus'])->name('content.contacts.update-status');
        Route::delete('/content/contacts/{contact}', [AdminContentController::class, 'destroyContact'])->name('content.contacts.destroy');
        
        // These are Session Management Routes
        Route::post('/extend-session', function() {
            session(['admin_last_activity' => time()]);
            return response()->json(['success' => true, 'message' => 'Session extended']);
        })->name('extend-session');
        
        // These are Menu Management Routes
        Route::post('/menus/bulk-action', [AdminMenuController::class, 'bulkAction'])->name('menus.bulk-action');
        Route::get('/menus/test-bulk', function() {
            return response()->json(['message' => 'Bulk action route is accessible', 'timestamp' => now()]);
        })->name('menus.test-bulk');
        Route::resource('menus', AdminMenuController::class);
        
        // These are Page Management Routes
        Route::resource('pages', AdminPageController::class);
        

    });
});

// Dynamic Pages Route (dont move it, must be at the end to avoid conflicts with other routes.)
use App\Http\Controllers\PageController;
Route::get('/page/{page}', [PageController::class, 'show'])->name('pages.show');
