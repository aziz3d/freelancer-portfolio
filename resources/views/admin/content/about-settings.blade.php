@extends('layouts.admin')

@section('title', 'About Me Settings')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">About Page Settings</h1>
            <p class="text-gray-600">Manage all content sections for the About Me page</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.content.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                ← Back to Content
            </a>
            <a href="{{ route('about') }}" target="_blank"
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Preview Page
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.content.about-bulk-update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                <div class="flex space-x-3">
                    <button type="button" id="expand-all" 
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Expand All
                    </button>
                    <button type="button" id="collapse-all" 
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Collapse All
                    </button>
                    <button type="submit" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md text-sm font-medium">
                        Save All Changes
                    </button>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            @foreach($aboutSections as $key => $title)
                @php
                    $content = $contents->get($key);
                    $isExpanded = old("sections.{$key}") ? true : false;
                @endphp
                
                <div class="bg-white shadow-sm rounded-lg content-section" data-section="{{ $key }}">
                    <div class="px-6 py-4 border-b border-gray-200 cursor-pointer section-header" 
                         onclick="toggleSection('{{ $key }}')">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <svg class="h-5 w-5 text-gray-400 transform transition-transform section-chevron {{ $isExpanded ? 'rotate-90' : '' }}" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($content)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Configured
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        Updated {{ $content->updated_at->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Not Set
                                    </span>
                                @endif
                                <a href="{{ route('admin.content.edit', $key) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                                   onclick="event.stopPropagation()">
                                    Advanced Edit
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section-content {{ $isExpanded ? '' : 'hidden' }}" id="section-{{ $key }}">
                        <div class="p-6 space-y-4">

                            <div>
                                <label for="{{ $key }}_title" class="block text-sm font-medium text-gray-700">
                                    Section Title
                                </label>
                                <input type="text" 
                                       name="sections[{{ $key }}][title]" 
                                       id="{{ $key }}_title"
                                       value="{{ old("sections.{$key}.title", $content->title ?? '') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            </div>

                    
                            <div>
                                <label for="{{ $key }}_content" class="block text-sm font-medium text-gray-700">
                                    Content
                                </label>
                                <textarea name="sections[{{ $key }}][content]" 
                                          id="{{ $key }}_content"
                                          rows="4" 
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">{{ old("sections.{$key}.content", $content->content ?? '') }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">
                                    You can use HTML and markdown formatting.
                                </p>
                            </div>

                     
                            @if($key === 'about_profile_summary')
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Profile Image</label>
                                        <div class="mt-1 flex items-center space-x-3">
                                            <input type="file" 
                                                   name="files[{{ $key }}]" 
                                                   accept="image/*"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                        </div>
                                        @if(isset($content->meta['image']))
                                            <div class="mt-2">
                                                <img src="{{ $content->meta['image'] }}" alt="Current profile image" class="h-20 w-20 object-cover rounded-lg">
                                                <p class="text-xs text-gray-500 mt-1">Current image</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Years of Experience</label>
                                        <input type="number" 
                                               name="sections[{{ $key }}][meta][years_experience]" 
                                               value="{{ old("sections.{$key}.meta.years_experience", $content->meta['years_experience'] ?? '5') }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Projects Completed</label>
                                        <input type="number" 
                                               name="sections[{{ $key }}][meta][projects_completed]" 
                                               value="{{ old("sections.{$key}.meta.projects_completed", $content->meta['projects_completed'] ?? '50') }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>
                                </div>
                            @endif



                            @if($key === 'about_social_links')
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-medium text-gray-900">Social Media Links</h4>
                                        <button type="button" onclick="addSocialLink('{{ $key }}')" 
                                                class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm">
                                            Add Link
                                        </button>
                                    </div>
                                    <div class="text-sm text-gray-600 mb-3">
                                        Select from popular social media platforms or add custom ones.
                                    </div>
                                    <div id="social-links-{{ $key }}" class="space-y-3">
                                        @php
                                            $socialLinks = old("sections.{$key}.meta.social_links", $content->meta['social_links'] ?? [
                                                ['platform' => 'LinkedIn', 'url' => '', 'icon' => 'linkedin'],
                                                ['platform' => 'GitHub', 'url' => '', 'icon' => 'github']
                                            ]);
                                            
                                            $predefinedPlatforms = [
                                                'linkedin' => 'LinkedIn',
                                                'github' => 'GitHub', 
                                                'twitter' => 'Twitter/X',
                                                'facebook' => 'Facebook',
                                                'instagram' => 'Instagram',
                                                'youtube' => 'YouTube',
                                                'artstation' => 'ArtStation',
                                                'behance' => 'Behance',
                                                'dribbble' => 'Dribbble',
                                                'discord' => 'Discord',
                                                'tiktok' => 'TikTok',
                                                'whatsapp' => 'WhatsApp',
                                                'telegram' => 'Telegram',
                                                'custom' => 'Custom Platform'
                                            ];
                                        @endphp
                                        @foreach($socialLinks as $index => $link)
                                            <div class="social-link-row bg-gray-50 p-4 rounded-lg border">
                                                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                                                    <div class="md:col-span-3">
                                                        <label class="block text-xs font-medium text-gray-700 mb-1">Platform</label>
                                                        <select name="sections[{{ $key }}][meta][social_links][{{ $index }}][icon]" 
                                                                class="platform-select w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm"
                                                                onchange="updatePlatformName(this, {{ $index }})">
                                                            @foreach($predefinedPlatforms as $value => $label)
                                                                <option value="{{ $value }}" {{ ($link['icon'] ?? '') === $value ? 'selected' : '' }}>
                                                                    {{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="md:col-span-3 custom-platform-name" style="{{ ($link['icon'] ?? '') !== 'custom' ? 'display: none;' : '' }}">
                                                        <label class="block text-xs font-medium text-gray-700 mb-1">Custom Name</label>
                                                        <input type="text" 
                                                               name="sections[{{ $key }}][meta][social_links][{{ $index }}][platform]" 
                                                               placeholder="Platform name" 
                                                               value="{{ $link['platform'] ?? '' }}" 
                                                               class="platform-name w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                                                    </div>
                                                    <div class="md:col-span-5">
                                                        <label class="block text-xs font-medium text-gray-700 mb-1">URL</label>
                                                        <input type="url" 
                                                               name="sections[{{ $key }}][meta][social_links][{{ $index }}][url]" 
                                                               placeholder="https://..." 
                                                               value="{{ $link['url'] ?? '' }}" 
                                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
                                                    </div>
                                                    <div class="md:col-span-1">
                                                        <button type="button" onclick="removeSocialLink(this)" 
                                                                class="w-full bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded text-sm">
                                                            Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($key === 'about_resume')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Resume File</label>
                                        <div class="mt-1">
                                            <input type="file" 
                                                   name="files[{{ $key }}]" 
                                                   accept=".pdf,.doc,.docx"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                        </div>
                                        @if(isset($content->meta['resume_path']))
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-600">Current file: {{ basename($content->meta['resume_path']) }}</p>
                                                <a href="{{ asset('storage/' . $content->meta['resume_path']) }}" target="_blank" class="text-purple-600 hover:text-purple-800 text-sm">View current resume</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Download Button Text</label>
                                        <input type="text" 
                                               name="sections[{{ $key }}][meta][button_text]" 
                                               value="{{ old("sections.{$key}.meta.button_text", $content->meta['button_text'] ?? 'Download Resume') }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>
                                </div>
                            @endif



                            @if($key === 'about_cta')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Primary Button Text</label>
                                        <input type="text" 
                                               name="sections[{{ $key }}][meta][primary_button_text]" 
                                               value="{{ old("sections.{$key}.meta.primary_button_text", $content->meta['primary_button_text'] ?? 'Start a Project') }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Secondary Button Text</label>
                                        <input type="text" 
                                               name="sections[{{ $key }}][meta][secondary_button_text]" 
                                               value="{{ old("sections.{$key}.meta.secondary_button_text", $content->meta['secondary_button_text'] ?? 'View My Work') }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </form>
</div>

<script>
function toggleSection(key) {
    const content = document.getElementById('section-' + key);
    const chevron = document.querySelector(`[data-section="${key}"] .section-chevron`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        chevron.classList.add('rotate-90');
    } else {
        content.classList.add('hidden');
        chevron.classList.remove('rotate-90');
    }
}

document.getElementById('expand-all').addEventListener('click', function() {
    document.querySelectorAll('.section-content').forEach(function(content) {
        content.classList.remove('hidden');
    });
    document.querySelectorAll('.section-chevron').forEach(function(chevron) {
        chevron.classList.add('rotate-90');
    });
});

document.getElementById('collapse-all').addEventListener('click', function() {
    document.querySelectorAll('.section-content').forEach(function(content) {
        content.classList.add('hidden');
    });
    document.querySelectorAll('.section-chevron').forEach(function(chevron) {
        chevron.classList.remove('rotate-90');
    });
});

function addSocialLink(sectionKey) {
    const container = document.getElementById('social-links-' + sectionKey);
    const rows = container.querySelectorAll('.social-link-row');
    const newIndex = rows.length;
    
    const predefinedOptions = `
        <option value="linkedin">LinkedIn</option>
        <option value="github">GitHub</option>
        <option value="twitter">Twitter/X</option>
        <option value="facebook">Facebook</option>
        <option value="instagram">Instagram</option>
        <option value="youtube">YouTube</option>
        <option value="artstation">ArtStation</option>
        <option value="behance">Behance</option>
        <option value="dribbble">Dribbble</option>
        <option value="discord">Discord</option>
        <option value="tiktok">TikTok</option>
        <option value="whatsapp">WhatsApp</option>
        <option value="telegram">Telegram</option>
        <option value="custom">Custom Platform</option>
    `;
    
    const newRow = document.createElement('div');
    newRow.className = 'social-link-row bg-gray-50 p-4 rounded-lg border';
    newRow.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Platform</label>
                <select name="sections[${sectionKey}][meta][social_links][${newIndex}][icon]" 
                        class="platform-select w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm"
                        onchange="updatePlatformName(this, ${newIndex})">
                    ${predefinedOptions}
                </select>
            </div>
            <div class="md:col-span-3 custom-platform-name" style="display: none;">
                <label class="block text-xs font-medium text-gray-700 mb-1">Custom Name</label>
                <input type="text" 
                       name="sections[${sectionKey}][meta][social_links][${newIndex}][platform]" 
                       placeholder="Platform name" 
                       class="platform-name w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
            </div>
            <div class="md:col-span-5">
                <label class="block text-xs font-medium text-gray-700 mb-1">URL</label>
                <input type="url" 
                       name="sections[${sectionKey}][meta][social_links][${newIndex}][url]" 
                       placeholder="https://..." 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">
            </div>
            <div class="md:col-span-1">
                <button type="button" onclick="removeSocialLink(this)" 
                        class="w-full bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded text-sm">
                    Remove
                </button>
            </div>
        </div>
    `;
    
    container.appendChild(newRow);
}


function updatePlatformName(selectElement, index) {
    const row = selectElement.closest('.social-link-row');
    const customNameDiv = row.querySelector('.custom-platform-name');
    const platformNameInput = row.querySelector('.platform-name');
    
    if (selectElement.value === 'custom') {
        customNameDiv.style.display = 'block';
        platformNameInput.required = true;
    } else {
        customNameDiv.style.display = 'none';
        platformNameInput.required = false;
       
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        platformNameInput.value = selectedOption.text;
    }
}

function removeSocialLink(button) {
    const row = button.closest('.social-link-row');
    row.remove();
    
   
    const container = row.closest('[id^="social-links-"]');
    const rows = container.querySelectorAll('.social-link-row');
    rows.forEach((row, index) => {
        const inputs = row.querySelectorAll('input, select');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${index}]`);
                input.setAttribute('name', newName);
            }
        });
        
       
        const select = row.querySelector('.platform-select');
        if (select) {
            select.setAttribute('onchange', `updatePlatformName(this, ${index})`);
        }
    });
}


document.addEventListener('DOMContentLoaded', function() {
    const socialLinkRows = document.querySelectorAll('.social-link-row');
    socialLinkRows.forEach((row, index) => {
        const select = row.querySelector('.platform-select');
        if (select) {
            updatePlatformName(select, index);
        }
    });
});
</script>
@endsection