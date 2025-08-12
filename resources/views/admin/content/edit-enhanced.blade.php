@extends('layouts.admin')

@section('title', 'Edit Content')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit {{ ucfirst(str_replace('_', ' ', $content->key)) }} Content</h1>
        <a href="{{ route('admin.content.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Back to Content
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg">
        <form method="POST" action="{{ route('admin.content.update', $content->key) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $content->title) }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-300 @enderror">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Optional title for this content section</p>
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="content" id="content" rows="10" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('content') border-red-300 @enderror">{{ old('content', $content->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    Main content for this section. You can use HTML and markdown formatting.
                </p>
            </div>

           
            @if($content->key === 'about_profile_summary')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Profile Summary Settings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_image" class="block text-sm font-medium text-gray-700">Profile Image Path</label>
                            <input type="text" name="meta[image]" id="meta_image" 
                                   value="{{ old('meta.image', $content->meta['image'] ?? '/images/about/profile.jpg') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Path to profile image (e.g., /images/about/profile.jpg)</p>
                        </div>
                        
                        <div>
                            <label for="meta_years_experience" class="block text-sm font-medium text-gray-700">Years of Experience</label>
                            <input type="number" name="meta[years_experience]" id="meta_years_experience" 
                                   value="{{ old('meta.years_experience', $content->meta['years_experience'] ?? '5') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="meta_projects_completed" class="block text-sm font-medium text-gray-700">Projects Completed</label>
                        <input type="number" name="meta[projects_completed]" id="meta_projects_completed" 
                               value="{{ old('meta.projects_completed', $content->meta['projects_completed'] ?? '50') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            @endif

         
            @if($content->key === 'about_skills')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Skills & Technologies Configuration</h3>
                    
                    <div id="skills-categories">
                        @php
                            $categories = old('meta.categories', $content->meta['categories'] ?? [
                                [
                                    'name' => 'Web Development',
                                    'skills' => [
                                        ['name' => 'Laravel', 'level' => 90, 'icon' => 'laravel'],
                                        ['name' => 'PHP', 'level' => 85, 'icon' => 'php'],
                                        ['name' => 'JavaScript', 'level' => 80, 'icon' => 'javascript']
                                    ]
                                ]
                            ]);
                        @endphp
                        
                        @foreach($categories as $categoryIndex => $category)
                            <div class="border border-gray-200 rounded-lg p-4 category-item">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium text-gray-900">Category {{ $categoryIndex + 1 }}</h4>
                                    <button type="button" class="text-red-600 hover:text-red-800 remove-category">Remove</button>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Category Name</label>
                                    <input type="text" name="meta[categories][{{ $categoryIndex }}][name]" 
                                           value="{{ $category['name'] ?? '' }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                
                                <div class="skills-list">
                                    @foreach($category['skills'] ?? [] as $skillIndex => $skill)
                                        <div class="grid grid-cols-4 gap-2 mb-2 skill-item">
                                            <input type="text" name="meta[categories][{{ $categoryIndex }}][skills][{{ $skillIndex }}][name]" 
                                                   placeholder="Skill name" value="{{ $skill['name'] ?? '' }}" 
                                                   class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <input type="number" name="meta[categories][{{ $categoryIndex }}][skills][{{ $skillIndex }}][level]" 
                                                   placeholder="Level (1-100)" value="{{ $skill['level'] ?? '' }}" min="1" max="100"
                                                   class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <input type="text" name="meta[categories][{{ $categoryIndex }}][skills][{{ $skillIndex }}][icon]" 
                                                   placeholder="Icon name" value="{{ $skill['icon'] ?? '' }}" 
                                                   class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <button type="button" class="text-red-600 hover:text-red-800 remove-skill">Remove</button>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <button type="button" class="mt-2 text-blue-600 hover:text-blue-800 add-skill">Add Skill</button>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" id="add-category" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Add Category
                    </button>
                </div>
            @endif

           
            @if($content->key === 'about_experience')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Work Experience Configuration</h3>
                    
                    <div id="experience-timeline">
                        @php
                            $timeline = old('meta.timeline', $content->meta['timeline'] ?? [
                                [
                                    'position' => 'Senior 3D Artist & Web Developer',
                                    'company' => 'Freelance',
                                    'location' => 'Remote',
                                    'period' => '2022 - Present',
                                    'description' => '',
                                    'achievements' => [],
                                    'technologies' => []
                                ]
                            ]);
                        @endphp
                        
                        @foreach($timeline as $expIndex => $experience)
                            <div class="border border-gray-200 rounded-lg p-4 experience-item">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium text-gray-900">Experience {{ $expIndex + 1 }}</h4>
                                    <button type="button" class="text-red-600 hover:text-red-800 remove-experience">Remove</button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Position</label>
                                        <input type="text" name="meta[timeline][{{ $expIndex }}][position]" 
                                               value="{{ $experience['position'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Company</label>
                                        <input type="text" name="meta[timeline][{{ $expIndex }}][company]" 
                                               value="{{ $experience['company'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Location</label>
                                        <input type="text" name="meta[timeline][{{ $expIndex }}][location]" 
                                               value="{{ $experience['location'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Period</label>
                                        <input type="text" name="meta[timeline][{{ $expIndex }}][period]" 
                                               value="{{ $experience['period'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="meta[timeline][{{ $expIndex }}][description]" rows="3" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $experience['description'] ?? '' }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700">Achievements (one per line)</label>
                                    <textarea name="meta[timeline][{{ $expIndex }}][achievements]" rows="3" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ isset($experience['achievements']) ? implode("\n", $experience['achievements']) : '' }}</textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Technologies (comma separated)</label>
                                    <input type="text" name="meta[timeline][{{ $expIndex }}][technologies]" 
                                           value="{{ isset($experience['technologies']) ? implode(', ', $experience['technologies']) : '' }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" id="add-experience" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Add Experience
                    </button>
                </div>
            @endif

            
            @if($content->key === 'about_education')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Education Configuration</h3>
                    
                    <div id="education-list">
                        @php
                            $education = old('meta.education', $content->meta['education'] ?? [
                                [
                                    'degree' => 'Bachelor of Computer Science',
                                    'institution' => 'University Name',
                                    'location' => 'City, Country',
                                    'period' => '2015 - 2019',
                                    'description' => '',
                                    'gpa' => ''
                                ]
                            ]);
                        @endphp
                        
                        @foreach($education as $eduIndex => $edu)
                            <div class="border border-gray-200 rounded-lg p-4 education-item">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium text-gray-900">Education {{ $eduIndex + 1 }}</h4>
                                    <button type="button" class="text-red-600 hover:text-red-800 remove-education">Remove</button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Degree</label>
                                        <input type="text" name="meta[education][{{ $eduIndex }}][degree]" 
                                               value="{{ $edu['degree'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Institution</label>
                                        <input type="text" name="meta[education][{{ $eduIndex }}][institution]" 
                                               value="{{ $edu['institution'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Location</label>
                                        <input type="text" name="meta[education][{{ $eduIndex }}][location]" 
                                               value="{{ $edu['location'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Period</label>
                                        <input type="text" name="meta[education][{{ $eduIndex }}][period]" 
                                               value="{{ $edu['period'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">GPA (optional)</label>
                                        <input type="text" name="meta[education][{{ $eduIndex }}][gpa]" 
                                               value="{{ $edu['gpa'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="meta[education][{{ $eduIndex }}][description]" rows="2" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $edu['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" id="add-education" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Add Education
                    </button>
                </div>
            @endif

            @if($content->key === 'about_certifications')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Certifications Configuration</h3>
                    
                    <div id="certifications-list">
                        @php
                            $certifications = old('meta.certifications', $content->meta['certifications'] ?? [
                                [
                                    'name' => 'Laravel Certified Developer',
                                    'issuer' => 'Laravel',
                                    'date' => '2023',
                                    'credential_id' => '',
                                    'url' => ''
                                ]
                            ]);
                        @endphp
                        
                        @foreach($certifications as $certIndex => $cert)
                            <div class="border border-gray-200 rounded-lg p-4 certification-item">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium text-gray-900">Certification {{ $certIndex + 1 }}</h4>
                                    <button type="button" class="text-red-600 hover:text-red-800 remove-certification">Remove</button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Certification Name</label>
                                        <input type="text" name="meta[certifications][{{ $certIndex }}][name]" 
                                               value="{{ $cert['name'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Issuer</label>
                                        <input type="text" name="meta[certifications][{{ $certIndex }}][issuer]" 
                                               value="{{ $cert['issuer'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date</label>
                                        <input type="text" name="meta[certifications][{{ $certIndex }}][date]" 
                                               value="{{ $cert['date'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Credential ID</label>
                                        <input type="text" name="meta[certifications][{{ $certIndex }}][credential_id]" 
                                               value="{{ $cert['credential_id'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Verification URL</label>
                                        <input type="url" name="meta[certifications][{{ $certIndex }}][url]" 
                                               value="{{ $cert['url'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" id="add-certification" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Add Certification
                    </button>
                </div>
            @endif

         
            @if($content->key === 'about_personal_info')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="meta[full_name]" id="meta_full_name" 
                                   value="{{ old('meta.full_name', $content->meta['full_name'] ?? 'Aziz Khan') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="meta_email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="meta[email]" id="meta_email" 
                                   value="{{ old('meta.email', $content->meta['email'] ?? '[email]') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="meta[phone]" id="meta_phone" 
                                   value="{{ old('meta.phone', $content->meta['phone'] ?? '[phone_number]') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="meta_location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="meta[location]" id="meta_location" 
                                   value="{{ old('meta.location', $content->meta['location'] ?? 'Karachi, Pakistan') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
                            <input type="date" name="meta[birth_date]" id="meta_birth_date" 
                                   value="{{ old('meta.birth_date', $content->meta['birth_date'] ?? '') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="meta_nationality" class="block text-sm font-medium text-gray-700">Nationality</label>
                            <input type="text" name="meta[nationality]" id="meta_nationality" 
                                   value="{{ old('meta.nationality', $content->meta['nationality'] ?? 'Pakistani') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="meta_languages" class="block text-sm font-medium text-gray-700">Languages (comma separated)</label>
                        <input type="text" name="meta[languages]" id="meta_languages" 
                               value="{{ old('meta.languages', isset($content->meta['languages']) ? implode(', ', $content->meta['languages']) : 'English, Urdu, Turkish') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            @endif

         
            @if($content->key === 'about_resume')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Resume Settings</h3>
                    
                    <div>
                        <label for="meta_resume_path" class="block text-sm font-medium text-gray-700">Resume File Path</label>
                        <input type="text" name="meta[resume_path]" id="meta_resume_path" 
                               value="{{ old('meta.resume_path', $content->meta['resume_path'] ?? 'public/documents/aziz-khan-resume.pdf') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Path to resume file in storage (e.g., public/documents/resume.pdf)</p>
                    </div>
                    
                    <div>
                        <label for="meta_resume_filename" class="block text-sm font-medium text-gray-700">Download Filename</label>
                        <input type="text" name="meta[resume_filename]" id="meta_resume_filename" 
                               value="{{ old('meta.resume_filename', $content->meta['resume_filename'] ?? 'Aziz-Khan-Resume.pdf') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Filename when user downloads the resume</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_last_updated" class="block text-sm font-medium text-gray-700">Last Updated</label>
                            <input type="date" name="meta[last_updated]" id="meta_last_updated" 
                                   value="{{ old('meta.last_updated', $content->meta['last_updated'] ?? date('Y-m-d')) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="meta_file_size" class="block text-sm font-medium text-gray-700">File Size (KB)</label>
                            <input type="number" name="meta[file_size]" id="meta_file_size" 
                                   value="{{ old('meta.file_size', $content->meta['file_size'] ?? '250') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            @endif

          
            @if($content->key === 'about_social_links')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Social Media Links Configuration</h3>
                    
                    <div id="social-links">
                        @php
                            $socialLinks = old('meta.social_links', $content->meta['social_links'] ?? [
                                ['platform' => 'LinkedIn', 'url' => '', 'icon' => 'linkedin'],
                                ['platform' => 'GitHub', 'url' => '', 'icon' => 'github'],
                                ['platform' => 'ArtStation', 'url' => '', 'icon' => 'artstation'],
                                ['platform' => 'Behance', 'url' => '', 'icon' => 'behance'],
                                ['platform' => 'Twitter', 'url' => '', 'icon' => 'twitter']
                            ]);
                        @endphp
                        
                        @foreach($socialLinks as $linkIndex => $link)
                            <div class="border border-gray-200 rounded-lg p-4 social-link-item">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium text-gray-900">Social Link {{ $linkIndex + 1 }}</h4>
                                    <button type="button" class="text-red-600 hover:text-red-800 remove-social-link">Remove</button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Platform Name</label>
                                        <input type="text" name="meta[social_links][{{ $linkIndex }}][platform]" 
                                               value="{{ $link['platform'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">URL</label>
                                        <input type="url" name="meta[social_links][{{ $linkIndex }}][url]" 
                                               value="{{ $link['url'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Icon Name</label>
                                        <input type="text" name="meta[social_links][{{ $linkIndex }}][icon]" 
                                               value="{{ $link['icon'] ?? '' }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" id="add-social-link" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Add Social Link
                    </button>
                </div>
            @endif

          
            @if($content->key === 'about_achievements')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Key Achievements Configuration</h3>
                    
                    <div>
                        <label for="meta_achievements" class="block text-sm font-medium text-gray-700">Achievements (one per line)</label>
                        <textarea name="meta[achievements]" id="meta_achievements" rows="8" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('meta.achievements', isset($content->meta['achievements']) ? implode("\n", $content->meta['achievements']) : "Completed 50+ successful projects\nMaintained 98% client satisfaction rate\nExpertise in 10+ programming languages and tools\nLed development of 5 major web applications\nCreated 100+ 3D models and animations\nReceived multiple client testimonials and referrals\nBuilt responsive websites for various industries\nOptimized website performance by 40% on average") }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Enter each achievement on a new line</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="meta_highlight_achievement" class="block text-sm font-medium text-gray-700">Highlight Achievement</label>
                            <input type="text" name="meta[highlight_achievement]" id="meta_highlight_achievement" 
                                   value="{{ old('meta.highlight_achievement', $content->meta['highlight_achievement'] ?? 'Award-winning 3D Artist & Web Developer') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Main achievement to highlight</p>
                        </div>
                        <div>
                            <label for="meta_years_active" class="block text-sm font-medium text-gray-700">Years Active</label>
                            <input type="text" name="meta[years_active]" id="meta_years_active" 
                                   value="{{ old('meta.years_active', $content->meta['years_active'] ?? '2019 - Present') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            @endif

        
            @if($content->key === 'about_hobbies')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Hobbies & Interests Configuration</h3>
                    
                    <div>
                        <label for="meta_hobbies" class="block text-sm font-medium text-gray-700">Hobbies & Interests (comma separated)</label>
                        <input type="text" name="meta[hobbies]" id="meta_hobbies" 
                               value="{{ old('meta.hobbies', isset($content->meta['hobbies']) ? implode(', ', $content->meta['hobbies']) : 'Photography, Gaming, Digital Art, Technology, Travel, Music, Reading, Fitness') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Separate each hobby with a comma</p>
                    </div>
                    
                    <div>
                        <label for="meta_favorite_hobby" class="block text-sm font-medium text-gray-700">Favorite Hobby</label>
                        <input type="text" name="meta[favorite_hobby]" id="meta_favorite_hobby" 
                               value="{{ old('meta.favorite_hobby', $content->meta['favorite_hobby'] ?? 'Digital Art & 3D Modeling') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Your main hobby or passion</p>
                    </div>
                    
                    <div>
                        <label for="meta_hobby_description" class="block text-sm font-medium text-gray-700">Hobby Description</label>
                        <textarea name="meta[hobby_description]" id="meta_hobby_description" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('meta.hobby_description', $content->meta['hobby_description'] ?? 'When I\'m not coding or creating 3D models for work, I love exploring new digital art techniques and experimenting with different creative tools. I also enjoy photography and capturing moments that inspire my creative work.') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Brief description of your hobbies and interests</p>
                    </div>
                </div>
            @endif

            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.content.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                    Update Content
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('content');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }

    if (document.getElementById('skills-categories')) {
        let categoryIndex = {{ count($categories ?? []) }};
        
    
        document.getElementById('add-category').addEventListener('click', function() {
            const categoriesContainer = document.getElementById('skills-categories');
            const categoryHtml = `
                <div class="border border-gray-200 rounded-lg p-4 category-item">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-gray-900">Category ${categoryIndex + 1}</h4>
                        <button type="button" class="text-red-600 hover:text-red-800 remove-category">Remove</button>
                    </div>
                    
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700">Category Name</label>
                        <input type="text" name="meta[categories][${categoryIndex}][name]" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <div class="skills-list"></div>
                    
                    <button type="button" class="mt-2 text-blue-600 hover:text-blue-800 add-skill">Add Skill</button>
                </div>
            `;
            categoriesContainer.insertAdjacentHTML('beforeend', categoryHtml);
            categoryIndex++;
        });
        
      
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-category')) {
                e.target.closest('.category-item').remove();
            }
        });
        
        
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-skill')) {
                const skillsList = e.target.previousElementSibling;
                const categoryItem = e.target.closest('.category-item');
                const categoryIdx = Array.from(categoryItem.parentNode.children).indexOf(categoryItem);
                const skillIndex = skillsList.children.length;
                
                const skillHtml = `
                    <div class="grid grid-cols-4 gap-2 mb-2 skill-item">
                        <input type="text" name="meta[categories][${categoryIdx}][skills][${skillIndex}][name]" 
                               placeholder="Skill name" 
                               class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <input type="number" name="meta[categories][${categoryIdx}][skills][${skillIndex}][level]" 
                               placeholder="Level (1-100)" min="1" max="100"
                               class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <input type="text" name="meta[categories][${categoryIdx}][skills][${skillIndex}][icon]" 
                               placeholder="Icon name" 
                               class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="button" class="text-red-600 hover:text-red-800 remove-skill">Remove</button>
                    </div>
                `;
                skillsList.insertAdjacentHTML('beforeend', skillHtml);
            }
        });
        
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-skill')) {
                e.target.closest('.skill-item').remove();
            }
        });
    }
});
</script>
@endsection