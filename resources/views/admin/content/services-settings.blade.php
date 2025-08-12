@extends('layouts.admin')

@section('title', 'Services Settings')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Services Settings</h1>
            <p class="text-sm text-gray-600">Manage the call-to-action section on the services page</p>
        </div>
        <a href="{{ route('admin.content.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            ← Back to Content
        </a>
    </div>

    <form action="{{ route('admin.content.services-bulk-update') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Services Page Settings</h2>
                <p class="text-sm text-gray-600">Configure the call-to-action section that appears at the bottom of the services page</p>
            </div>
            
            <div class="p-6 space-y-8">
                @foreach($servicesSections as $key => $title)
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
                            @if($key === 'services_section')
                              
                                <div>
                                    <label for="sections_{{ $key }}_title" class="block text-sm font-medium text-gray-700 mb-2">
                                        Section Title
                                    </label>
                                    <input type="text" 
                                           name="sections[{{ $key }}][title]" 
                                           id="sections_{{ $key }}_title"
                                           value="{{ old("sections.{$key}.title", $content->title ?? 'Services') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Services">
                                </div>
                                
                                <div>
                                    <label for="sections_{{ $key }}_content" class="block text-sm font-medium text-gray-700 mb-2">
                                        Section Description
                                    </label>
                                    <textarea name="sections[{{ $key }}][content]" 
                                              id="sections_{{ $key }}_content"
                                              rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Professional services tailored to your needs">{{ old("sections.{$key}.content", $content->content ?? "Professional services tailored to your needs") }}</textarea>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="hidden" name="sections[{{ $key }}][meta][is_visible]" value="0">
                                    <input type="checkbox" 
                                           name="sections[{{ $key }}][meta][is_visible]" 
                                           id="sections_{{ $key }}_is_visible"
                                           value="1"
                                           {{ old("sections.{$key}.meta.is_visible", $content && isset($content->meta['is_visible']) ? $content->meta['is_visible'] : true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="sections_{{ $key }}_is_visible" class="ml-2 block text-sm text-gray-900">
                                        Show this section on the front page
                                    </label>
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
                                                This controls the Services section title and description that appears on your homepage.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($key === 'services_cta')
                              
                                <div>
                                    <label for="sections_{{ $key }}_title" class="block text-sm font-medium text-gray-700 mb-2">
                                        CTA Headline
                                    </label>
                                    <input type="text" 
                                           name="sections[{{ $key }}][title]" 
                                           id="sections_{{ $key }}_title"
                                           value="{{ old("sections.{$key}.title", $content->title ?? 'Ready to Start Your Project?') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Ready to Start Your Project?">
                                </div>
                                
                                <div>
                                    <label for="sections_{{ $key }}_content" class="block text-sm font-medium text-gray-700 mb-2">
                                        CTA Description
                                    </label>
                                    <textarea name="sections[{{ $key }}][content]" 
                                              id="sections_{{ $key }}_content"
                                              rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Let's discuss how I can help bring your vision to life with professional, high-quality work tailored to your specific needs.">{{ old("sections.{$key}.content", $content->content ?? "Let's discuss how I can help bring your vision to life with professional, high-quality work tailored to your specific needs.") }}</textarea>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="sections_{{ $key }}_primary_button_text" class="block text-sm font-medium text-gray-700 mb-2">
                                            Primary Button Text
                                        </label>
                                        <input type="text" 
                                               name="sections[{{ $key }}][meta][primary_button_text]" 
                                               id="sections_{{ $key }}_primary_button_text"
                                               value="{{ old("sections.{$key}.meta.primary_button_text", $content->meta['primary_button_text'] ?? 'Get In Touch') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Get In Touch">
                                    </div>
                                    <div>
                                        <label for="sections_{{ $key }}_primary_button_url" class="block text-sm font-medium text-gray-700 mb-2">
                                            Primary Button URL
                                        </label>
                                        <select name="sections[{{ $key }}][meta][primary_button_url]" 
                                                id="sections_{{ $key }}_primary_button_url"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="{{ route('contact') }}" {{ old("sections.{$key}.meta.primary_button_url", $content->meta['primary_button_url'] ?? route('contact')) === route('contact') ? 'selected' : '' }}>Contact Page</option>
                                            <option value="{{ route('projects.index') }}" {{ old("sections.{$key}.meta.primary_button_url", $content->meta['primary_button_url'] ?? '') === route('projects.index') ? 'selected' : '' }}>Projects Page</option>
                                            <option value="{{ route('about') }}" {{ old("sections.{$key}.meta.primary_button_url", $content->meta['primary_button_url'] ?? '') === route('about') ? 'selected' : '' }}>About Page</option>
                                            <option value="{{ route('blog.index') }}" {{ old("sections.{$key}.meta.primary_button_url", $content->meta['primary_button_url'] ?? '') === route('blog.index') ? 'selected' : '' }}>Blog Page</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="sections_{{ $key }}_secondary_button_text" class="block text-sm font-medium text-gray-700 mb-2">
                                            Secondary Button Text
                                        </label>
                                        <input type="text" 
                                               name="sections[{{ $key }}][meta][secondary_button_text]" 
                                               id="sections_{{ $key }}_secondary_button_text"
                                               value="{{ old("sections.{$key}.meta.secondary_button_text", $content->meta['secondary_button_text'] ?? 'View My Work') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="View My Work">
                                    </div>
                                    <div>
                                        <label for="sections_{{ $key }}_secondary_button_url" class="block text-sm font-medium text-gray-700 mb-2">
                                            Secondary Button URL
                                        </label>
                                        <select name="sections[{{ $key }}][meta][secondary_button_url]" 
                                                id="sections_{{ $key }}_secondary_button_url"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="{{ route('projects.index') }}" {{ old("sections.{$key}.meta.secondary_button_url", $content->meta['secondary_button_url'] ?? route('projects.index')) === route('projects.index') ? 'selected' : '' }}>Projects Page</option>
                                            <option value="{{ route('contact') }}" {{ old("sections.{$key}.meta.secondary_button_url", $content->meta['secondary_button_url'] ?? '') === route('contact') ? 'selected' : '' }}>Contact Page</option>
                                            <option value="{{ route('about') }}" {{ old("sections.{$key}.meta.secondary_button_url", $content->meta['secondary_button_url'] ?? '') === route('about') ? 'selected' : '' }}>About Page</option>
                                            <option value="{{ route('blog.index') }}" {{ old("sections.{$key}.meta.secondary_button_url", $content->meta['secondary_button_url'] ?? '') === route('blog.index') ? 'selected' : '' }}>Blog Page</option>
                                        </select>
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
                                                This call-to-action section appears at the bottom of the services page to encourage visitors to take action.
                                            </p>
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
                Save Services Settings
            </button>
        </div>
    </form>
</div>
@endsection