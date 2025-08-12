@extends('layouts.admin')

@section('title', 'Contact Settings')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Contact Settings</h1>
            <p class="text-sm text-gray-600">Manage contact information, social links, and reCAPTCHA settings</p>
        </div>
        <a href="{{ route('admin.content.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            ← Back to Content
        </a>
    </div>



    <form action="{{ route('admin.content.contact-bulk-update') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Contact Settings</h2>
                <p class="text-sm text-gray-600">Configure your contact information and settings</p>
            </div>
            
            <div class="p-6 space-y-8">
                @foreach($contactSections as $key => $title)
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
                            @if($key === 'contact_info')
                              
                                <div>
                                    <label for="sections_{{ $key }}_title" class="block text-sm font-medium text-gray-700 mb-2">
                                        Section Title
                                    </label>
                                    <input type="text" 
                                           name="sections[{{ $key }}][title]" 
                                           id="sections_{{ $key }}_title"
                                           value="{{ old("sections.{$key}.title", $content->title ?? 'Contact Information') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                           placeholder="Contact Information">
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="sections_{{ $key }}_email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address
                                        </label>
                                        <input type="email" 
                                               name="sections[{{ $key }}][meta][email]" 
                                               id="sections_{{ $key }}_email"
                                               value="{{ old("sections.{$key}.meta.email", $content->meta['email'] ?? '') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                               placeholder="aziz@example.com">
                                    </div>
                                    <div>
                                        <label for="sections_{{ $key }}_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number <span class="text-sm text-gray-500">(optional)</span>
                                        </label>
                                        <input type="text" 
                                               name="sections[{{ $key }}][meta][phone]" 
                                               id="sections_{{ $key }}_phone"
                                               value="{{ old("sections.{$key}.meta.phone", $content->meta['phone'] ?? '') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                               placeholder="+1 (555) 123-4567">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="sections_{{ $key }}_location" class="block text-sm font-medium text-gray-700 mb-2">
                                        Location
                                    </label>
                                    <input type="text" 
                                           name="sections[{{ $key }}][meta][location]" 
                                           id="sections_{{ $key }}_location"
                                           value="{{ old("sections.{$key}.meta.location", $content->meta['location'] ?? '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                           placeholder="Available for remote work">
                                </div>
                                
                                <div>
                                    <label for="sections_{{ $key }}_response_time" class="block text-sm font-medium text-gray-700 mb-2">
                                        Response Time
                                    </label>
                                    <input type="text" 
                                           name="sections[{{ $key }}][meta][response_time]" 
                                           id="sections_{{ $key }}_response_time"
                                           value="{{ old("sections.{$key}.meta.response_time", $content->meta['response_time'] ?? '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                           placeholder="Usually within 24 hours">
                                </div>
                                
                                <div>
                                    <label for="sections_{{ $key }}_availability" class="block text-sm font-medium text-gray-700 mb-2">
                                        Availability Status
                                    </label>
                                    <select name="sections[{{ $key }}][meta][availability]" 
                                            id="sections_{{ $key }}_availability"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                                        <option value="available" {{ old("sections.{$key}.meta.availability", $content->meta['availability'] ?? '') === 'available' ? 'selected' : '' }}>Available for new projects</option>
                                        <option value="busy" {{ old("sections.{$key}.meta.availability", $content->meta['availability'] ?? '') === 'busy' ? 'selected' : '' }}>Currently busy</option>
                                        <option value="unavailable" {{ old("sections.{$key}.meta.availability", $content->meta['availability'] ?? '') === 'unavailable' ? 'selected' : '' }}>Not available</option>
                                    </select>
                                </div>
                                
                            @elseif($key === 'contact_social')
                                
                                <div>
                                    <label for="sections_{{ $key }}_title" class="block text-sm font-medium text-gray-700 mb-2">
                                        Section Title
                                    </label>
                                    <input type="text" 
                                           name="sections[{{ $key }}][title]" 
                                           id="sections_{{ $key }}_title"
                                           value="{{ old("sections.{$key}.title", $content->title ?? 'Connect With Me') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                           placeholder="Connect With Me">
                                </div>
                                
                                <div>
                                    <label for="sections_{{ $key }}_content" class="block text-sm font-medium text-gray-700 mb-2">
                                        Description
                                    </label>
                                    <textarea name="sections[{{ $key }}][content]" 
                                              id="sections_{{ $key }}_content"
                                              rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                              placeholder="Let's connect on social media and professional networks">{{ old("sections.{$key}.content", $content->content ?? '') }}</textarea>
                                </div>
                                
                                @php
                                    $socialPlatforms = [
                                        'linkedin' => 'LinkedIn',
                                        'github' => 'GitHub',
                                        'twitter' => 'Twitter',
                                        'instagram' => 'Instagram',
                                        'facebook' => 'Facebook',
                                        'youtube' => 'YouTube',
                                        'behance' => 'Behance',
                                        'dribbble' => 'Dribbble',
                                        'medium' => 'Medium',
                                        'dev' => 'Dev.to',
                                        'stackoverflow' => 'Stack Overflow',
                                        'discord' => 'Discord',
                                        'telegram' => 'Telegram'
                                    ];
                                @endphp
                                
                                <div class="space-y-3">
                                    <h4 class="text-sm font-medium text-gray-700">Social Media Links</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($socialPlatforms as $platform => $label)
                                            <div>
                                                <label for="sections_{{ $key }}_{{ $platform }}" class="block text-sm font-medium text-gray-700 mb-1">
                                                    {{ $label }}
                                                </label>
                                                <input type="url" 
                                                       name="sections[{{ $key }}][meta][social_links][{{ $platform }}]" 
                                                       id="sections_{{ $key }}_{{ $platform }}"
                                                       value="{{ old("sections.{$key}.meta.social_links.{$platform}", $content->meta['social_links'][$platform] ?? '') }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                                       placeholder="https://{{ $platform }}.com/username">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                            @elseif($key === 'contact_recaptcha')
                              
                                <div>
                                    <label for="sections_{{ $key }}_title" class="block text-sm font-medium text-gray-700 mb-2">
                                        Section Title
                                    </label>
                                    <input type="text" 
                                           name="sections[{{ $key }}][title]" 
                                           id="sections_{{ $key }}_title"
                                           value="{{ old("sections.{$key}.title", $content->title ?? 'Google reCAPTCHA Settings') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                           placeholder="Google reCAPTCHA Settings">
                                </div>
                                
                                <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-800">
                                                Get your reCAPTCHA keys from <a href="https://www.google.com/recaptcha/admin" target="_blank" class="underline">Google reCAPTCHA Admin Console</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="flex items-center mb-2">
                                    
                                        <input type="hidden" name="sections[{{ $key }}][meta][enabled]" value="0">
                                        <input type="checkbox" 
                                               name="sections[{{ $key }}][meta][enabled]" 
                                               id="sections_{{ $key }}_enabled"
                                               value="1"
                                               {{ old("sections.{$key}.meta.enabled", $content->meta['enabled'] ?? false) ? 'checked' : '' }}
                                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                        <label for="sections_{{ $key }}_enabled" class="ml-2 block text-sm font-medium text-gray-700">
                                            Enable Google reCAPTCHA
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="sections_{{ $key }}_site_key" class="block text-sm font-medium text-gray-700 mb-2">
                                        Site Key (Public Key)
                                    </label>
                                    <input type="text" 
                                           name="sections[{{ $key }}][meta][site_key]" 
                                           id="sections_{{ $key }}_site_key"
                                           value="{{ old("sections.{$key}.meta.site_key", $content->meta['site_key'] ?? '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                           placeholder="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI">
                                </div>
                                
                                <div>
                                    <label for="sections_{{ $key }}_secret_key" class="block text-sm font-medium text-gray-700 mb-2">
                                        Secret Key (Private Key)
                                    </label>
                                    <input type="password" 
                                           name="sections[{{ $key }}][meta][secret_key]" 
                                           id="sections_{{ $key }}_secret_key"
                                           value="{{ old("sections.{$key}.meta.secret_key", $content->meta['secret_key'] ?? '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                           placeholder="6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe">
                                </div>
                                
                                <div>
                                    <label for="sections_{{ $key }}_version" class="block text-sm font-medium text-gray-700 mb-2">
                                        reCAPTCHA Version
                                    </label>
                                    <select name="sections[{{ $key }}][meta][version]" 
                                            id="sections_{{ $key }}_version"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                                        <option value="v2" {{ old("sections.{$key}.meta.version", $content->meta['version'] ?? 'v2') === 'v2' ? 'selected' : '' }}>reCAPTCHA v2</option>
                                        <option value="v3" {{ old("sections.{$key}.meta.version", $content->meta['version'] ?? 'v2') === 'v3' ? 'selected' : '' }}>reCAPTCHA v3</option>
                                    </select>
                                </div>
                                
                                <div id="recaptcha_v3_settings" style="display: {{ old('sections.contact_recaptcha.meta.version', $content->meta['version'] ?? 'v2') === 'v3' ? 'block' : 'none' }}">
                                    <label for="sections_{{ $key }}_threshold" class="block text-sm font-medium text-gray-700 mb-2">
                                        Score Threshold (v3 only)
                                    </label>
                                    <input type="number" 
                                           name="sections[{{ $key }}][meta][threshold]" 
                                           id="sections_{{ $key }}_threshold"
                                           value="{{ old("sections.{$key}.meta.threshold", $content->meta['threshold'] ?? '0.5') }}"
                                           step="0.1"
                                           min="0"
                                           max="1"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                           placeholder="0.5">
                                    <p class="text-xs text-gray-500 mt-1">Score threshold (0.0 - 1.0). Lower scores indicate more likely bot traffic.</p>
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
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Save Contact Settings
            </button>
        </div>
    </form>
</div>

<script>
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
</script>
@endsection