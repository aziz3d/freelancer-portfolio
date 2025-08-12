@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">General Settings</h1>
            <p class="text-sm text-gray-600">Manage Hero Section and Footer Content</p>
        </div>
        <a href="{{ route('admin.content.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            ← Back to Content
        </a>
    </div>



    <form action="{{ route('admin.content.general-bulk-update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">General Content Sections</h2>
                <p class="text-sm text-gray-600">Configure your site's main content areas</p>
            </div>
            
            <div class="p-6 space-y-8">
                @foreach($generalSections as $key => $title)
                    @php
                        $content = $contents->get($key);
                    @endphp
                    
                    <div class="border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
                            @if($content && $content->updated_at)
                                <span class="text-sm text-gray-500">
                                    Last updated: {{ $content->updated_at->format('M d, Y \a\t g:i A') }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="space-y-4">
                         
                            <div>
                                <label for="sections_{{ $key }}_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Title
                                </label>
                                <input type="text" 
                                       name="sections[{{ $key }}][title]" 
                                       id="sections_{{ $key }}_title"
                                       value="{{ old("sections.{$key}.title", $content->title ?? '') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter {{ strtolower($title) }} title">
                            </div>
                            
                           
                            <div>
                                <label for="sections_{{ $key }}_content" class="block text-sm font-medium text-gray-700 mb-2">
                                    Content
                                </label>
                                <textarea name="sections[{{ $key }}][content]" 
                                          id="sections_{{ $key }}_content"
                                          rows="6"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Enter {{ strtolower($title) }} content">{{ old("sections.{$key}.content", $content->content ?? '') }}</textarea>
                            </div>
                            
                            @if($key === 'hero')
                              
                                <div class="space-y-4">
                                    <div>
                                        <label for="sections_{{ $key }}_subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                                            Subtitle <span class="text-gray-500">(appears below main title)</span>
                                        </label>
                                        <input type="text" 
                                               name="sections[{{ $key }}][meta][subtitle]" 
                                               id="sections_{{ $key }}_subtitle"
                                               value="{{ old("sections.{$key}.meta.subtitle", $content->meta['subtitle'] ?? '2D/3D Artist & Web Developer') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="2D/3D Artist & Web Developer">
                                    </div>
                                    
                                
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Text Colors</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label for="sections_{{ $key }}_title_color_text" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Title Color
                                                </label>
                                                <div class="flex items-center space-x-2">
                                                    <input type="color" 
                                                           id="sections_{{ $key }}_title_color_picker"
                                                           value="{{ old("sections.{$key}.meta.title_color", $content->meta['title_color'] ?? '#111827') }}"
                                                           class="w-12 h-10 border border-gray-300 rounded cursor-pointer"
                                                           onchange="updateColorText('{{ $key }}', 'title_color', this.value)">
                                                    <input type="text" 
                                                           name="sections[{{ $key }}][meta][title_color]" 
                                                           id="sections_{{ $key }}_title_color_text"
                                                           value="{{ old("sections.{$key}.meta.title_color", $content->meta['title_color'] ?? '#111827') }}"
                                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                                                           placeholder="#111827"
                                                           onchange="updateColorPicker('{{ $key }}', 'title_color', this.value)">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="sections_{{ $key }}_subtitle_color_text" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Subtitle Color
                                                </label>
                                                <div class="flex items-center space-x-2">
                                                    <input type="color" 
                                                           id="sections_{{ $key }}_subtitle_color_picker"
                                                           value="{{ old("sections.{$key}.meta.subtitle_color", $content->meta['subtitle_color'] ?? '#4B5563') }}"
                                                           class="w-12 h-10 border border-gray-300 rounded cursor-pointer"
                                                           onchange="updateColorText('{{ $key }}', 'subtitle_color', this.value)">
                                                    <input type="text" 
                                                           name="sections[{{ $key }}][meta][subtitle_color]" 
                                                           id="sections_{{ $key }}_subtitle_color_text"
                                                           value="{{ old("sections.{$key}.meta.subtitle_color", $content->meta['subtitle_color'] ?? '#4B5563') }}"
                                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                                                           placeholder="#4B5563"
                                                           onchange="updateColorPicker('{{ $key }}', 'subtitle_color', this.value)">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="sections_{{ $key }}_description_color_text" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Description Color
                                                </label>
                                                <div class="flex items-center space-x-2">
                                                    <input type="color" 
                                                           id="sections_{{ $key }}_description_color_picker"
                                                           value="{{ old("sections.{$key}.meta.description_color", $content->meta['description_color'] ?? '#6B7280') }}"
                                                           class="w-12 h-10 border border-gray-300 rounded cursor-pointer"
                                                           onchange="updateColorText('{{ $key }}', 'description_color', this.value)">
                                                    <input type="text" 
                                                           name="sections[{{ $key }}][meta][description_color]" 
                                                           id="sections_{{ $key }}_description_color_text"
                                                           value="{{ old("sections.{$key}.meta.description_color", $content->meta['description_color'] ?? '#6B7280') }}"
                                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                                                           placeholder="#6B7280"
                                                           onchange="updateColorPicker('{{ $key }}', 'description_color', this.value)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="sections_{{ $key }}_cta_text" class="block text-sm font-medium text-gray-700 mb-2">
                                                Primary Button Text
                                            </label>
                                            <input type="text" 
                                                   name="sections[{{ $key }}][meta][cta_text]" 
                                                   id="sections_{{ $key }}_cta_text"
                                                   value="{{ old("sections.{$key}.meta.cta_text", $content->meta['cta_text'] ?? 'View Projects') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="View Projects">
                                        </div>
                                        <div>
                                            <label for="sections_{{ $key }}_cta_url" class="block text-sm font-medium text-gray-700 mb-2">
                                                Primary Button URL
                                            </label>
                                            <input type="url" 
                                                   name="sections[{{ $key }}][meta][cta_url]" 
                                                   id="sections_{{ $key }}_cta_url"
                                                   value="{{ old("sections.{$key}.meta.cta_url", $content->meta['cta_url'] ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="/projects">
                                        </div>
                                    </div>
                                  
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Profile Photo</h4>
                                        <div class="space-y-4">
                                         
                                            @if(isset($content->meta['profile_photo']) && !empty($content->meta['profile_photo']))
                                                <div class="flex items-center space-x-4">
                                                    <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200">
                                                        <img src="{{ $content->meta['profile_photo'] }}" 
                                                             alt="Current profile photo" 
                                                             class="w-full h-full object-cover">
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">Current Photo</p>
                                                        <p class="text-xs text-gray-500">Upload a new photo to replace</p>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                        
                                            <div>
                                                <label for="hero_profile_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Upload Profile Photo
                                                </label>
                                                <input type="file" 
                                                       name="hero_profile_photo" 
                                                       id="hero_profile_photo"
                                                       accept="image/*"
                                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Recommended: Square image (1:1 ratio), minimum 400x400px, JPG or PNG format
                                                </p>
                                            </div>
                                            
                                         
                                            {{-- <div class="border-t border-gray-200 pt-4">
                                                <label for="sections_{{ $key }}_profile_photo_url" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Or Enter Photo URL
                                                </label>
                                                <input type="url" 
                                                       name="sections[{{ $key }}][meta][profile_photo]" 
                                                       id="sections_{{ $key }}_profile_photo_url"
                                                       value="{{ old("sections.{$key}.meta.profile_photo", $content->meta['profile_photo'] ?? '') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                       placeholder="https://example.com/photo.jpg">
                                                <p class="text-xs text-gray-500 mt-1">
                                                    If you upload a file above, it will override this URL
                                                </p>
                                            </div> --}}
                                        </div>
                                    </div>

                                    
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Background Animation Presets</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label for="sections_{{ $key }}_animation_preset" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Choose Animation Theme
                                                </label>
                                                <select name="sections[{{ $key }}][meta][animation_preset]" 
                                                        id="sections_{{ $key }}_animation_preset"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="default" {{ old("sections.{$key}.meta.animation_preset", $content->meta['animation_preset'] ?? 'default') == 'default' ? 'selected' : '' }}>
                                                        Default Creative Animation
                                                    </option>
                                                </select>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Select a background animation theme that matches your professional identity
                                                </p>
                                            </div>
                                            
                                           
                                            <div class="border border-gray-200 rounded-lg p-3 bg-white">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-xs font-medium text-gray-600">Preview</span>
                                                    <button type="button" 
                                                            onclick="previewAnimation()"
                                                            class="text-xs text-primary-600 hover:text-primary-700 font-medium">
                                                        Preview Animation
                                                    </button>
                                                </div>
                                                <div id="animation-preview" class="h-16 bg-gradient-to-r from-gray-100 to-gray-200 rounded relative overflow-hidden">
                                                    <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-500">
                                                        Select an animation to preview
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-blue-800">
                                                    <strong>Title:</strong> Main hero heading (supports HTML like &lt;span class="text-primary-600"&gt;Name&lt;/span&gt;)<br>
                                                    <strong>Content:</strong> Description text below the subtitle<br>
                                                    <strong>Profile Photo:</strong> Circular photo displayed on the right side of hero section<br>
                                                    <strong>Animation Preset:</strong> Choose from 7 professional background animations<br>
                                                    <strong>Secondary button:</strong> "Need Help?" button always links to contact page
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @if($key === 'footer')
                               
                                <div class="space-y-6">
                                  
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="sections_{{ $key }}_copyright" class="block text-sm font-medium text-gray-700 mb-2">
                                                Copyright Text
                                            </label>
                                            <input type="text" 
                                                   name="sections[{{ $key }}][meta][copyright]" 
                                                   id="sections_{{ $key }}_copyright"
                                                   value="{{ old("sections.{$key}.meta.copyright", $content->meta['copyright'] ?? '© ' . date('Y') . ' Aziz Khan. All rights reserved.') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="© {{ date('Y') }} Your Name. All rights reserved.">
                                        </div>
                                        <div>
                                            <label for="sections_{{ $key }}_email" class="block text-sm font-medium text-gray-700 mb-2">
                                                Contact Email
                                            </label>
                                            <input type="email" 
                                                   name="sections[{{ $key }}][meta][email]" 
                                                   id="sections_{{ $key }}_email"
                                                   value="{{ old("sections.{$key}.meta.email", $content->meta['email'] ?? 'contact@azizkhan.dev') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="contact@example.com">
                                        </div>
                                    </div>

                                 
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Quick Links</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label for="sections_{{ $key }}_quick_links_title" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Section Title
                                                </label>
                                                <input type="text" 
                                                       name="sections[{{ $key }}][meta][quick_links][title]" 
                                                       id="sections_{{ $key }}_quick_links_title"
                                                       value="{{ old("sections.{$key}.meta.quick_links.title", $content->meta['quick_links']['title'] ?? 'Quick Links') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                       placeholder="Quick Links">
                                            </div>
                                            @php
                                                $quickLinks = [
                                                    'home' => 'Home',
                                                    'about' => 'About',
                                                    'projects' => 'Projects',
                                                    'contact' => 'Contact'
                                                ];
                                            @endphp
                                            <div class="grid grid-cols-2 gap-3">
                                                @foreach($quickLinks as $linkKey => $linkLabel)
                                                    <div>
                                                        <label for="sections_{{ $key }}_quick_link_{{ $linkKey }}" class="block text-xs font-medium text-gray-600 mb-1">
                                                            {{ $linkLabel }} Link
                                                        </label>
                                                        <input type="text" 
                                                               name="sections[{{ $key }}][meta][quick_links][links][{{ $linkKey }}]" 
                                                               id="sections_{{ $key }}_quick_link_{{ $linkKey }}"
                                                               value="{{ old("sections.{$key}.meta.quick_links.links.{$linkKey}", $content->meta['quick_links']['links'][$linkKey] ?? '/' . ($linkKey === 'home' ? '' : $linkKey)) }}"
                                                               class="w-full px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                               placeholder="/{{ $linkKey === 'home' ? '' : $linkKey }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                   
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Services</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label for="sections_{{ $key }}_services_title" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Section Title
                                                </label>
                                                <input type="text" 
                                                       name="sections[{{ $key }}][meta][services][title]" 
                                                       id="sections_{{ $key }}_services_title"
                                                       value="{{ old("sections.{$key}.meta.services.title", $content->meta['services']['title'] ?? 'Services') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                       placeholder="Services">
                                            </div>
                                            <div>
                                                <label for="sections_{{ $key }}_services_list" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Services List <span class="text-gray-500">(one per line)</span>
                                                </label>
                                                <textarea name="sections[{{ $key }}][meta][services][list]" 
                                                          id="sections_{{ $key }}_services_list"
                                                          rows="4"
                                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                          placeholder="Web Development&#10;3D Modeling&#10;UI/UX Design&#10;Graphic Design">{{ old("sections.{$key}.meta.services.list", is_array($content->meta['services']['list'] ?? null) ? implode("\n", $content->meta['services']['list']) : ($content->meta['services']['list'] ?? "Web Development\n3D Modeling\nUI/UX Design\nGraphic Design")) }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                   
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Available Worldwide (Remote)</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label for="sections_{{ $key }}_remote_title" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Section Title
                                                </label>
                                                <input type="text" 
                                                       name="sections[{{ $key }}][meta][remote][title]" 
                                                       id="sections_{{ $key }}_remote_title"
                                                       value="{{ old("sections.{$key}.meta.remote.title", $content->meta['remote']['title'] ?? 'Available Worldwide') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                       placeholder="Available Worldwide">
                                            </div>
                                            <div>
                                                <label for="sections_{{ $key }}_remote_description" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Description
                                                </label>
                                                <textarea name="sections[{{ $key }}][meta][remote][description]" 
                                                          id="sections_{{ $key }}_remote_description"
                                                          rows="3"
                                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                          placeholder="Working remotely with clients worldwide. Available in multiple time zones.">{{ old("sections.{$key}.meta.remote.description", $content->meta['remote']['description'] ?? 'Working remotely with clients worldwide. Available in multiple time zones.') }}</textarea>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="sections_{{ $key }}_remote_timezone" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Primary Timezone
                                                    </label>
                                                    <input type="text" 
                                                           name="sections[{{ $key }}][meta][remote][timezone]" 
                                                           id="sections_{{ $key }}_remote_timezone"
                                                           value="{{ old("sections.{$key}.meta.remote.timezone", $content->meta['remote']['timezone'] ?? 'UTC+5 (PKT)') }}"
                                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                           placeholder="UTC+5 (PKT)">
                                                </div>
                                                <div>
                                                    <label for="sections_{{ $key }}_remote_availability" class="block text-sm font-medium text-gray-700 mb-2">
                                                        Availability
                                                    </label>
                                                    <input type="text" 
                                                           name="sections[{{ $key }}][meta][remote][availability]" 
                                                           id="sections_{{ $key }}_remote_availability"
                                                           value="{{ old("sections.{$key}.meta.remote.availability", $content->meta['remote']['availability'] ?? 'Mon-Fri, 9AM-6PM') }}"
                                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                           placeholder="Mon-Fri, 9AM-6PM">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                  
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Social Links</h4>
                                        <div class="space-y-3">
                                            <div>
                                                <label for="sections_{{ $key }}_social_title" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Section Title
                                                </label>
                                                <input type="text" 
                                                       name="sections[{{ $key }}][meta][social][title]" 
                                                       id="sections_{{ $key }}_social_title"
                                                       value="{{ old("sections.{$key}.meta.social.title", $content->meta['social']['title'] ?? 'Follow Me') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                       placeholder="Follow Me">
                                            </div>
                                            @php
                                                $socialPlatforms = [
                                                    'linkedin' => 'LinkedIn',
                                                    'github' => 'GitHub',
                                                    'twitter' => 'Twitter',
                                                    'instagram' => 'Instagram',
                                                    'facebook' => 'Facebook',
                                                    'youtube' => 'YouTube'
                                                ];
                                            @endphp
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                @foreach($socialPlatforms as $platform => $label)
                                                    <div>
                                                        <label for="sections_{{ $key }}_social_{{ $platform }}" class="block text-xs font-medium text-gray-600 mb-1">
                                                            {{ $label }}
                                                        </label>
                                                        <input type="url" 
                                                               name="sections[{{ $key }}][meta][social][links][{{ $platform }}]" 
                                                               id="sections_{{ $key }}_social_{{ $platform }}"
                                                               value="{{ old("sections.{$key}.meta.social.links.{$platform}", $content->meta['social']['links'][$platform] ?? '') }}"
                                                               class="w-full px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                               placeholder="https://{{ $platform }}.com/username">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-blue-800">
                                                    <strong>Title:</strong> Brand name displayed in footer<br>
                                                    <strong>Content:</strong> Brief description about you/your business<br>
                                                    <strong>Email:</strong> Contact email shown in footer and used for mailto links<br>
                                                    <strong>Quick Links:</strong> Navigation links in footer<br>
                                                    <strong>Services:</strong> List of services you offer<br>
                                                    <strong>Remote Work:</strong> Information about worldwide availability<br>
                                                    <strong>Social Links:</strong> Your social media profiles
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.content.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" 
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Save General Settings
            </button>
        </div>
    </form>
</div>

<script>
function updateColorText(section, colorType, value) {
    const textInput = document.getElementById(`sections_${section}_${colorType}_text`);
    if (textInput) {
        textInput.value = value;
    }
}

function updateColorPicker(section, colorType, value) {
    const colorPicker = document.getElementById(`sections_${section}_${colorType}_picker`);
    if (colorPicker && /^#[0-9A-F]{6}$/i.test(value)) {
        colorPicker.value = value;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const versionSelect = document.getElementById('sections_contact_recaptcha_version');
    const v3Settings = document.getElementById('recaptcha_v3_settings');
    
    if (versionSelect && v3Settings) {
        versionSelect.addEventListener('change', function() {
            if (this.value === 'v3') {
                v3Settings.style.display = 'block';
            } else {
                v3Settings.style.display = 'none';
            }
        });
    }
});


function previewAnimation() {
    const select = document.getElementById('sections_hero_animation_preset');
    const preview = document.getElementById('animation-preview');
    
    if (!select || !preview) return;
    
    const selectedValue = select.value;
    
    
    preview.innerHTML = '';
    
    
    switch(selectedValue) {
        case 'galaxy':
            preview.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-purple-900 to-black">
                    <div class="absolute top-2 left-4 w-1 h-1 bg-white rounded-full animate-pulse"></div>
                    <div class="absolute top-6 right-8 w-1 h-1 bg-yellow-200 rounded-full animate-ping"></div>
                    <div class="absolute bottom-4 left-8 w-1 h-1 bg-blue-200 rounded-full animate-pulse"></div>
                    <div class="absolute top-1 right-4 w-2 h-8 bg-gradient-to-b from-white to-transparent opacity-60 animate-bounce transform rotate-45"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-xs text-white">Galaxy Theme</div>
                </div>
            `;
            break;
        case 'graphic_designer':
            preview.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-br from-pink-200 via-purple-200 to-indigo-200">
                    <div class="absolute top-2 left-2 w-3 h-3 bg-pink-400 rounded-full animate-bounce"></div>
                    <div class="absolute top-4 right-4 w-2 h-2 bg-purple-400 transform rotate-45 animate-spin"></div>
                    <div class="absolute bottom-2 left-6 w-4 h-1 bg-indigo-400 animate-pulse"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-700">Graphic Designer</div>
                </div>
            `;
            break;
        case 'web_developer':
            preview.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-br from-green-200 via-blue-200 to-gray-800">
                    <div class="absolute top-2 left-2 text-green-600 text-xs font-mono animate-pulse">&lt;/&gt;</div>
                    <div class="absolute top-2 right-2 text-blue-600 text-xs font-mono animate-bounce">{ }</div>
                    <div class="absolute bottom-2 left-4 text-gray-600 text-xs font-mono animate-pulse">function()</div>
                    <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-700">Web Developer</div>
                </div>
            `;
            break;
        case 'freelancer':
            preview.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-br from-blue-200 via-gray-100 to-green-200">
                    <div class="absolute top-2 left-2 w-2 h-2 bg-blue-500 rounded-full animate-ping"></div>
                    <div class="absolute top-4 right-2 w-3 h-1 bg-green-500 animate-pulse"></div>
                    <div class="absolute bottom-2 right-4 w-2 h-2 bg-gray-500 transform rotate-45 animate-bounce"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-700">Freelancer</div>
                </div>
            `;
            break;
        case 'women_empowerment':
            preview.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-br from-rose-200 via-pink-100 to-purple-200">
                    <div class="absolute top-2 left-3 w-2 h-2 bg-rose-400 rounded-full animate-pulse"></div>
                    <div class="absolute top-3 right-3 w-3 h-3 bg-pink-400 rounded-full animate-bounce"></div>
                    <div class="absolute bottom-3 left-2 w-2 h-2 bg-purple-400 rounded-full animate-ping"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-700">Women Empowerment</div>
                </div>
            `;
            break;
        case 'content_creator':
            preview.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-br from-orange-200 via-yellow-100 to-red-200">
                    <div class="absolute top-2 left-2 w-2 h-3 bg-orange-400 animate-pulse"></div>
                    <div class="absolute top-3 right-2 w-3 h-2 bg-yellow-500 animate-bounce"></div>
                    <div class="absolute bottom-2 left-4 w-1 h-4 bg-red-400 animate-ping"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-700">Content Creator</div>
                </div>
            `;
            break;
        case 'women_freelancer':
            preview.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-br from-pink-200 via-rose-100 to-indigo-200">
                    <div class="absolute top-2 left-2 w-2 h-2 bg-pink-400 rounded-full animate-pulse"></div>
                    <div class="absolute top-4 right-3 w-2 h-2 bg-rose-400 rounded-full animate-bounce"></div>
                    <div class="absolute bottom-2 right-2 w-3 h-1 bg-indigo-400 animate-ping"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-700">Women Freelancer</div>
                </div>
            `;
            break;
        default:
            preview.innerHTML = `
                <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100">
                    <div class="absolute top-2 left-2 w-2 h-2 bg-blue-400 rounded-full animate-bounce"></div>
                    <div class="absolute top-3 right-3 w-2 h-2 bg-purple-400 transform rotate-45 animate-spin"></div>
                    <div class="absolute bottom-2 left-4 w-3 h-1 bg-pink-400 animate-pulse"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-700">Default Creative</div>
                </div>
            `;
    }
}


document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('sections_hero_animation_preset');
    if (select) {
        select.addEventListener('change', previewAnimation);
        
        previewAnimation();
    }
});
</script>
@endsection