<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Testimonial;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::orderBy('key')->get();
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.content.index', compact('contents', 'contacts'));
    }

    public function editContent($key)
    {
        $content = Content::where('key', $key)->first();

        if (!$content) {
            $content = new Content(['key' => $key]);
        }

        $aboutSections = [
            'about_profile_summary',
            'about_skills',
            'about_experience',
            'about_resume',
            'about_social_links',
            'about_cta'
        ];

        if (in_array($key, $aboutSections)) {
            return view('admin.content.edit-enhanced', compact('content'));
        }

        return view('admin.content.edit', compact('content'));
    }

    public function generalSettings()
    {
        $generalSections = [
            'hero' => 'Hero Section',
            'footer' => 'Footer Content'
        ];

        $contents = Content::whereIn('key', array_keys($generalSections))->get()->keyBy('key');

        return view('admin.content.general-settings', compact('generalSections', 'contents'));
    }



    public function brandingSettings()
    {
        $brandingSections = [
            'site_branding' => 'Site Branding & Identity'
        ];

        $contents = Content::whereIn('key', array_keys($brandingSections))->get()->keyBy('key');

        return view('admin.content.branding-settings', compact('brandingSections', 'contents'));
    }

    public function contactSettings()
    {
        $contactSections = [
            'contact_info' => 'Contact Information',
            'contact_social' => 'Connect With Me',
            'contact_recaptcha' => 'Google reCAPTCHA Settings'
        ];

        $contents = Content::whereIn('key', array_keys($contactSections))->get()->keyBy('key');

        return view('admin.content.contact-settings', compact('contactSections', 'contents'));
    }

    public function aboutSettings()
    {
        $aboutSections = [
            'about_profile_summary' => 'Profile Summary',
            'about_skills' => 'Skills & Technologies',
            'about_experience' => 'Work Experience',
            'about_resume' => 'Resume Settings',
            'about_social_links' => 'Social Media Links',
            'about_cta' => 'Call to Action Section'
        ];

        $contents = Content::whereIn('key', array_keys($aboutSections))->get()->keyBy('key');

        return view('admin.content.about-settings', compact('aboutSections', 'contents'));
    }

    public function servicesSettings()
    {
        $servicesSections = [
            'services_section' => 'Services Section Settings',
            'services_cta' => 'Services Page Call to Action'
        ];

        $contents = Content::whereIn('key', array_keys($servicesSections))->get()->keyBy('key');

        return view('admin.content.services-settings', compact('servicesSections', 'contents'));
    }

    public function projectsSettings()
    {
        $projectsSections = [
            'featured_work_section' => 'Featured Work Section Settings'
        ];

        $contents = Content::whereIn('key', array_keys($projectsSections))->get()->keyBy('key');

        return view('admin.content.projects-settings', compact('projectsSections', 'contents'));
    }

    public function pagesTitleSettings()
    {
        $pagesSections = [
            'page_titles_about' => 'About Me Page',
            'page_titles_projects' => 'Projects Page',
            'page_titles_blog' => 'Blog Page',
            'page_titles_services' => 'Services Page',
            'page_titles_contact' => 'Contact Me Page'
        ];

        $contents = Content::whereIn('key', array_keys($pagesSections))->get()->keyBy('key');

        return view('admin.content.pages-title-settings', compact('pagesSections', 'contents'));
    }

    public function blogSettings()
    {
        $blogSections = [
            'latest_articles_section' => 'Latest Articles Section Settings'
        ];

        $contents = Content::whereIn('key', array_keys($blogSections))->get()->keyBy('key');

        return view('admin.content.blog-settings', compact('blogSections', 'contents'));
    }

    public function testimonialsSettings()
    {
        $testimonialsSections = [
            'testimonials_section' => 'What Clients Say Section Settings'
        ];

        $contents = Content::whereIn('key', array_keys($testimonialsSections))->get()->keyBy('key');

        return view('admin.content.testimonials-settings', compact('testimonialsSections', 'contents'));
    }

    public function bulkUpdateGeneral(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.meta' => 'nullable|array',
            'hero_profile_photo' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        
        if ($request->hasFile('hero_profile_photo')) {
            $photoFile = $request->file('hero_profile_photo');
            $path = $photoFile->store('hero', 'public');
            
           
            if (!isset($validated['sections']['hero'])) {
                $validated['sections']['hero'] = [];
            }
            if (!isset($validated['sections']['hero']['meta'])) {
                $validated['sections']['hero']['meta'] = [];
            }
            
            $validated['sections']['hero']['meta']['profile_photo'] = '/storage/' . $path;
        }

        foreach ($validated['sections'] as $key => $data) {
          
            if ($key === 'footer' && isset($data['meta']['services']['list']) && is_string($data['meta']['services']['list'])) {
                $services = explode("\n", $data['meta']['services']['list']);
                $services = array_map('trim', $services);
                $services = array_filter($services, function ($service) {
                    return !empty($service);
                });
                $data['meta']['services']['list'] = array_values($services);
            }

            
            $existingContent = Content::where('key', $key)->first();

            
            if ($existingContent && isset($existingContent->meta)) {
                if (!isset($data['meta'])) {
                    $data['meta'] = [];
                }

               
                if ($key === 'hero' && 
                    isset($existingContent->meta['profile_photo']) && 
                    !isset($data['meta']['profile_photo']) && 
                    !$request->hasFile('hero_profile_photo')) {
                    $data['meta']['profile_photo'] = $existingContent->meta['profile_photo'];
                }

                
                foreach ($existingContent->meta as $metaKey => $metaValue) {
                    if (!isset($data['meta'][$metaKey])) {
                        $data['meta'][$metaKey] = $metaValue;
                    }
                }
            }

            Content::updateOrCreate(
                ['key' => $key],
                $data
            );
        }

        return redirect()->route('admin.content.general-settings')
            ->with('success', 'General settings updated successfully.');
    }

    public function bulkUpdateBranding(Request $request)
    {
        try {
            $validated = $request->validate([
                'sections' => 'nullable|array',
                'sections.*' => 'nullable|array',
                'sections.*.title' => 'nullable|string|max:255',
                'sections.*.content' => 'nullable|string',
                'sections.*.meta' => 'nullable|array',
                'logo_file' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'favicon_file' => 'nullable|file|mimes:ico,png|max:1024',
            ]);

            
            if (!isset($validated['sections'])) {
                $validated['sections'] = [];
            }

            
            if ($request->hasFile('logo_file')) {
                $logoFile = $request->file('logo_file');
                $path = $logoFile->store('branding', 'public');

               
                if (!isset($validated['sections']['site_branding'])) {
                    $validated['sections']['site_branding'] = [];
                }
                if (!isset($validated['sections']['site_branding']['meta'])) {
                    $validated['sections']['site_branding']['meta'] = [];
                }

                $validated['sections']['site_branding']['meta']['logo'] = '/storage/' . $path;
            }

            
            if ($request->hasFile('favicon_file')) {
                $faviconFile = $request->file('favicon_file');
                $path = $faviconFile->store('branding', 'public');

                
                if (!isset($validated['sections']['site_branding'])) {
                    $validated['sections']['site_branding'] = [];
                }
                if (!isset($validated['sections']['site_branding']['meta'])) {
                    $validated['sections']['site_branding']['meta'] = [];
                }

                $validated['sections']['site_branding']['meta']['favicon'] = '/storage/' . $path;
            }

         
            if (!isset($validated['sections']['site_branding'])) {
                $validated['sections']['site_branding'] = [];
            }

            foreach ($validated['sections'] as $key => $data) {
               
                $existingContent = Content::where('key', $key)->first();

               
                if ($existingContent && isset($existingContent->meta)) {
                    if (!isset($data['meta'])) {
                        $data['meta'] = [];
                    }

                    
                    if (isset($existingContent->meta['logo']) && !isset($data['meta']['logo'])) {
                        $data['meta']['logo'] = $existingContent->meta['logo'];
                    }

                    
                    if (isset($existingContent->meta['favicon']) && !isset($data['meta']['favicon'])) {
                        $data['meta']['favicon'] = $existingContent->meta['favicon'];
                    }

                    
                    foreach ($existingContent->meta as $metaKey => $metaValue) {
                        if (!isset($data['meta'][$metaKey])) {
                            $data['meta'][$metaKey] = $metaValue;
                        }
                    }
                }

                Content::updateOrCreate(
                    ['key' => $key],
                    $data
                );
            }

            return redirect()->route('admin.content.branding-settings')
                ->with('success', 'Site branding updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.content.branding-settings')
                ->with('error', 'Failed to update site branding: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function bulkUpdateAbout(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.meta' => 'nullable|array',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:10240',
        ]);

        
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $key => $file) {
                if ($file) {
                    $path = $file->store('content', 'public');
                    if (!isset($validated['sections'][$key]['meta'])) {
                        $validated['sections'][$key]['meta'] = [];
                    }

                    
                    if ($key === 'about_profile_summary') {
                        $validated['sections'][$key]['meta']['image'] = '/storage/' . $path;
                    } elseif ($key === 'about_resume') {
                        $validated['sections'][$key]['meta']['resume_path'] = $path;
                    }
                }
            }
        }

        foreach ($validated['sections'] as $key => $data) {
            
            $existingContent = Content::where('key', $key)->first();

            
            if ($existingContent && isset($existingContent->meta)) {
                if (!isset($data['meta'])) {
                    $data['meta'] = [];
                }

                
                if (
                    $key === 'about_profile_summary' &&
                    isset($existingContent->meta['image']) &&
                    !isset($data['meta']['image'])
                ) {
                    $data['meta']['image'] = $existingContent->meta['image'];
                }

                
                if (
                    $key === 'about_resume' &&
                    isset($existingContent->meta['resume_path']) &&
                    !isset($data['meta']['resume_path'])
                ) {
                    $data['meta']['resume_path'] = $existingContent->meta['resume_path'];
                }

                
                foreach ($existingContent->meta as $metaKey => $metaValue) {
                    if (!isset($data['meta'][$metaKey])) {
                        $data['meta'][$metaKey] = $metaValue;
                    }
                }
            }

            
            if ($key === 'about_experience' && isset($data['meta']['timeline'])) {
                foreach ($data['meta']['timeline'] as $index => $experience) {
                    
                    if (isset($experience['achievements']) && is_string($experience['achievements'])) {
                        $achievements = explode("\n", $experience['achievements']);
                        $achievements = array_map('trim', $achievements);
                        $achievements = array_filter($achievements, function ($achievement) {
                            return !empty($achievement);
                        });
                        $data['meta']['timeline'][$index]['achievements'] = array_values($achievements);
                    }

                    
                    if (isset($experience['technologies']) && is_string($experience['technologies'])) {
                        $technologies = explode(',', $experience['technologies']);
                        $technologies = array_map('trim', $technologies);
                        $technologies = array_filter($technologies, function ($tech) {
                            return !empty($tech);
                        });
                        $data['meta']['timeline'][$index]['technologies'] = array_values($technologies);
                    }
                }
            }

            Content::updateOrCreate(
                ['key' => $key],
                $data
            );
        }

        return redirect()->route('admin.content.about-settings')
            ->with('success', 'About page settings updated successfully.');
    }

    public function bulkUpdateContact(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.meta' => 'nullable|array',
        ]);

        foreach ($validated['sections'] as $key => $data) {
            
            if ($key === 'contact_recaptcha' && isset($data['meta']['enabled'])) {
                $data['meta']['enabled'] = (bool) $data['meta']['enabled'];
            }

            $existingContent = Content::where('key', $key)->first();

            
            if ($existingContent && isset($existingContent->meta)) {
                if (!isset($data['meta'])) {
                    $data['meta'] = [];
                }

                
                foreach ($existingContent->meta as $metaKey => $metaValue) {
                    if (!isset($data['meta'][$metaKey])) {
                        $data['meta'][$metaKey] = $metaValue;
                    }
                }
            }

            Content::updateOrCreate(
                ['key' => $key],
                $data
            );
        }

        return redirect()->route('admin.content.contact-settings')
            ->with('success', 'Contact settings updated successfully.');
    }

    public function bulkUpdateServices(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.meta' => 'nullable|array',
        ]);

        foreach ($validated['sections'] as $key => $data) {
            
            if (isset($data['meta']['is_visible'])) {
                $data['meta']['is_visible'] = (bool) $data['meta']['is_visible'];
            }

            $existingContent = Content::where('key', $key)->first();

            if ($existingContent && isset($existingContent->meta)) {
                if (!isset($data['meta'])) {
                    $data['meta'] = [];
                }

                
                foreach ($existingContent->meta as $metaKey => $metaValue) {
                    if (!isset($data['meta'][$metaKey])) {
                        $data['meta'][$metaKey] = $metaValue;
                    }
                }
            }

            Content::updateOrCreate(
                ['key' => $key],
                $data
            );
        }

        return redirect()->route('admin.content.services-settings')
            ->with('success', 'Services settings updated successfully.');
    }

    public function bulkUpdateProjects(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.meta' => 'nullable|array',
        ]);

        foreach ($validated['sections'] as $key => $data) {
            
            if (isset($data['meta']['is_visible'])) {
                $data['meta']['is_visible'] = (bool) $data['meta']['is_visible'];
            }

            $existingContent = Content::where('key', $key)->first();

            if ($existingContent && isset($existingContent->meta)) {
                if (!isset($data['meta'])) {
                    $data['meta'] = [];
                }

                
                foreach ($existingContent->meta as $metaKey => $metaValue) {
                    if (!isset($data['meta'][$metaKey])) {
                        $data['meta'][$metaKey] = $metaValue;
                    }
                }
            }

            Content::updateOrCreate(
                ['key' => $key],
                $data
            );
        }

        return redirect()->route('admin.content.projects-settings')
            ->with('success', 'Featured Work settings updated successfully.');
    }

    public function bulkUpdatePagesTitle(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.meta' => 'nullable|array',
        ]);

        foreach ($validated['sections'] as $key => $data) {
            
            $existingContent = Content::where('key', $key)->first();

            if ($existingContent && isset($existingContent->meta)) {
                if (!isset($data['meta'])) {
                    $data['meta'] = [];
                }

                foreach ($existingContent->meta as $metaKey => $metaValue) {
                    if (!isset($data['meta'][$metaKey])) {
                        $data['meta'][$metaKey] = $metaValue;
                    }
                }
            }

            Content::updateOrCreate(
                ['key' => $key],
                $data
            );
        }

        return redirect()->route('admin.content.pages-title-settings')
            ->with('success', 'Pages Title settings updated successfully.');
    }

    public function bulkUpdateBlog(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.meta' => 'nullable|array',
        ]);

        foreach ($validated['sections'] as $key => $data) {
            
            if (isset($data['meta']['is_visible'])) {
                $data['meta']['is_visible'] = (bool) $data['meta']['is_visible'];
            }

            
            $existingContent = Content::where('key', $key)->first();

            if ($existingContent && isset($existingContent->meta)) {
                if (!isset($data['meta'])) {
                    $data['meta'] = [];
                }

                foreach ($existingContent->meta as $metaKey => $metaValue) {
                    if (!isset($data['meta'][$metaKey])) {
                        $data['meta'][$metaKey] = $metaValue;
                    }
                }
            }

            Content::updateOrCreate(
                ['key' => $key],
                $data
            );
        }

        return redirect()->route('admin.content.blog-settings')
            ->with('success', 'Latest Articles settings updated successfully.');
    }

    public function bulkUpdateTestimonials(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.meta' => 'nullable|array',
        ]);

        foreach ($validated['sections'] as $key => $data) {
            
            if (isset($data['meta']['is_visible'])) {
                $data['meta']['is_visible'] = (bool) $data['meta']['is_visible'];
            }

            
            $existingContent = Content::where('key', $key)->first();

            
            if ($existingContent && isset($existingContent->meta)) {
                if (!isset($data['meta'])) {
                    $data['meta'] = [];
                }

                
                foreach ($existingContent->meta as $metaKey => $metaValue) {
                    if (!isset($data['meta'][$metaKey])) {
                        $data['meta'][$metaKey] = $metaValue;
                    }
                }
            }

            Content::updateOrCreate(
                ['key' => $key],
                $data
            );
        }

        return redirect()->route('admin.content.testimonials-settings')
            ->with('success', 'What Clients Say settings updated successfully.');
    }

    public function updateContent(Request $request, $key)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'meta' => 'nullable|array',
        ]);

        $validated['key'] = $key;

        
        $existingContent = Content::where('key', $key)->first();

        
        if ($existingContent && isset($existingContent->meta)) {
            if (!isset($validated['meta'])) {
                $validated['meta'] = [];
            }

            
            foreach ($existingContent->meta as $metaKey => $metaValue) {
                if (!isset($validated['meta'][$metaKey])) {
                    $validated['meta'][$metaKey] = $metaValue;
                }
            }
        }

        
        if ($key === 'skills' && isset($validated['meta']['skills'])) {
            $skills = explode("\n", $validated['meta']['skills']);
            $skills = array_map('trim', $skills);
            $skills = array_filter($skills, function ($skill) {
                return !empty($skill);
            });
            $validated['meta']['skills'] = array_values($skills);
        }

        
        if ($key === 'about_experience' && isset($validated['meta']['timeline'])) {
            foreach ($validated['meta']['timeline'] as $index => $experience) {
                
                if (isset($experience['achievements']) && is_string($experience['achievements'])) {
                    $achievements = explode("\n", $experience['achievements']);
                    $achievements = array_map('trim', $achievements);
                    $achievements = array_filter($achievements, function ($achievement) {
                        return !empty($achievement);
                    });
                    $validated['meta']['timeline'][$index]['achievements'] = array_values($achievements);
                }

                
                if (isset($experience['technologies']) && is_string($experience['technologies'])) {
                    $technologies = explode(',', $experience['technologies']);
                    $technologies = array_map('trim', $technologies);
                    $technologies = array_filter($technologies, function ($tech) {
                        return !empty($tech);
                    });
                    $validated['meta']['timeline'][$index]['technologies'] = array_values($technologies);
                }
            }
        }

        Content::updateOrCreate(
            ['key' => $key],
            $validated
        );

        return redirect()->route('admin.content.index')
            ->with('success', 'Content updated successfully.');
    }

    public function testimonials()
    {
        $testimonials = Testimonial::orderBy('sort_order')->paginate(10);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function createTestimonial()
    {
        return view('admin.testimonials.create');
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'integer|min:1|max:5',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('testimonials', 'public');
            $validated['avatar'] = $avatarPath;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['rating'] = $validated['rating'] ?? 5;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    public function editTestimonial(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'integer|min:1|max:5',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        
        if ($request->hasFile('avatar')) {
            
            if ($testimonial->avatar && file_exists(public_path('storage/' . $testimonial->avatar))) {
                unlink(public_path('storage/' . $testimonial->avatar));
            }

            $avatarPath = $request->file('avatar')->store('testimonials', 'public');
            $validated['avatar'] = $avatarPath;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['rating'] = $validated['rating'] ?? $testimonial->rating;
        $validated['sort_order'] = $validated['sort_order'] ?? $testimonial->sort_order;

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        
        if ($testimonial->avatar && file_exists(public_path('storage/' . $testimonial->avatar))) {
            unlink(public_path('storage/' . $testimonial->avatar));
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }

    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.content.contacts', compact('contacts'));
    }

    public function showContact(Contact $contact)
    {
        
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.content.contacts-show', compact('contact'));
    }

    public function updateContactStatus(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,read,replied',
        ]);

        $contact->update($validated);

        return redirect()->route('admin.content.contacts')
            ->with('success', 'Contact status updated successfully.');
    }

    public function destroyContact(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.content.contacts')
            ->with('success', 'Contact deleted successfully.');
    }

    public function bulkContactAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,mark_read,mark_replied',
            'contacts' => 'required|array|min:1',
            'contacts.*' => 'exists:contacts,id',
        ]);

        $contactIds = $validated['contacts'];
        $action = $validated['action'];

        switch ($action) {
            case 'delete':
                $deletedCount = Contact::whereIn('id', $contactIds)->delete();
                $message = "Successfully deleted {$deletedCount} contact(s).";
                break;
            case 'mark_read':
                $updatedCount = Contact::whereIn('id', $contactIds)->update(['status' => 'read']);
                $message = "Successfully marked {$updatedCount} contact(s) as read.";
                break;
            case 'mark_replied':
                $updatedCount = Contact::whereIn('id', $contactIds)->update(['status' => 'replied']);
                $message = "Successfully marked {$updatedCount} contact(s) as replied.";
                break;
            default:
                $message = 'Invalid action selected.';
        }

        return redirect()->route('admin.content.contacts')
            ->with('success', $message);
    }
}
