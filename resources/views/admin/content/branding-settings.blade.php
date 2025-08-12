@extends('layouts.admin')

@section('title', 'Site Branding Settings')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Site Branding Settings</h1>
            <p class="text-sm text-gray-600">Manage your site logo, favicon, and title</p>
        </div>
        <a href="{{ route('admin.content.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            ← Back to Content
        </a>
    </div>



    <form action="{{ route('admin.content.branding-bulk-update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white shadow-sm rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Site Branding & Identity</h2>
                <p class="text-sm text-gray-600">Configure your site's visual identity and branding elements</p>
            </div>
            
            <div class="p-6 space-y-8">
                @foreach($brandingSections as $key => $title)
                    @php
                        $content = $contents->get($key);
                    @endphp
                    
                    <div class="border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
                            @if($content && $content->updated_at)
                                <span class="text-sm text-gray-500">
                                    Last updated: {{ $content->updated_at->format('M d, Y \a\t g:i A') }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="space-y-6">
                           
                            <div>
                                <label for="sections_{{ $key }}_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Site Title
                                </label>
                                <input type="text" 
                                       name="sections[{{ $key }}][title]" 
                                       id="sections_{{ $key }}_title"
                                       value="{{ old("sections.{$key}.title", $content->title ?? 'Aziz Khan') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                       placeholder="Your Site Title">
                                <p class="text-xs text-gray-500 mt-1">This will appear in browser tabs and search results</p>
                            </div>
                            
                           
                            <div>
                                <label for="sections_{{ $key }}_content" class="block text-sm font-medium text-gray-700 mb-2">
                                    Site Description
                                </label>
                                <textarea name="sections[{{ $key }}][content]" 
                                          id="sections_{{ $key }}_content"
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                          placeholder="Brief description of your site">{{ old("sections.{$key}.content", $content->content ?? '') }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Used for SEO meta descriptions</p>
                            </div>
                            
                           
                            <div>
                                <label for="logo_upload" class="block text-sm font-medium text-gray-700 mb-2">
                                    Site Logo
                                </label>
                                
                                @if(isset($content->meta['logo']))
                                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                        <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ $content->meta['logo'] }}" 
                                                 alt="Current Logo" 
                                                 class="h-12 w-auto object-contain bg-white p-2 border border-gray-200 rounded">
                                            <div class="text-sm text-gray-500">
                                                <p>Height: Auto-fits navbar</p>
                                                <p>Format: PNG, JPG, SVG recommended</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <input type="file"
                                       name="logo_file"
                                       id="logo_upload"
                                       accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                                <p class="text-xs text-gray-500 mt-1">
                                    Upload a new logo (PNG, JPG, SVG). Recommended: transparent background, max 2MB. 
                                    Logo will automatically fit navbar height.
                                </p>
                            </div>
                            
                        
                            <div>
                                <label for="favicon_upload" class="block text-sm font-medium text-gray-700 mb-2">
                                    Favicon
                                </label>
                                
                                @if(isset($content->meta['favicon']))
                                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                        <p class="text-sm text-gray-600 mb-2">Current Favicon:</p>
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ $content->meta['favicon'] }}" 
                                                 alt="Current Favicon" 
                                                 class="h-8 w-8 object-contain bg-white p-1 border border-gray-200 rounded">
                                            <div class="text-sm text-gray-500">
                                                <p>Size: 16x16 or 32x32 pixels</p>
                                                <p>Format: ICO or PNG</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <input type="file"
                                       name="favicon_file"
                                       id="favicon_upload"
                                       accept=".ico,.png"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                                <p class="text-xs text-gray-500 mt-1">
                                    Upload a favicon (ICO or PNG). Recommended: 32x32 pixels, max 1MB. 
                                    This appears in browser tabs and bookmarks.
                                </p>
                            </div>
                            
                          
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="sections_{{ $key }}_brand_color" class="block text-sm font-medium text-gray-700 mb-2">
                                        Primary Brand Color
                                    </label>
                                    <div class="flex items-center space-x-2">
                                        <input type="color" 
                                               name="sections[{{ $key }}][meta][brand_color]" 
                                               id="sections_{{ $key }}_brand_color"
                                               value="{{ old("sections.{$key}.meta.brand_color", $content->meta['brand_color'] ?? '#3B82F6') }}"
                                               class="h-10 w-16 border border-gray-300 rounded-md">
                                        <input type="text" 
                                               value="{{ old("sections.{$key}.meta.brand_color", $content->meta['brand_color'] ?? '#3B82F6') }}"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                               readonly>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Used for accents and highlights</p>
                                </div>
                                
                                <div>
                                    <label for="sections_{{ $key }}_logo_alt" class="block text-sm font-medium text-gray-700 mb-2">
                                        Logo Alt Text
                                    </label>
                                    <input type="text" 
                                           name="sections[{{ $key }}][meta][logo_alt]" 
                                           id="sections_{{ $key }}_logo_alt"
                                           value="{{ old("sections.{$key}.meta.logo_alt", $content->meta['logo_alt'] ?? 'Site Logo') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                           placeholder="Descriptive text for logo">
                                    <p class="text-xs text-gray-500 mt-1">Accessibility text for screen readers</p>
                                </div>
                            </div>
                            
                          
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-4">SEO Settings</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="sections_{{ $key }}_meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">
                                            Meta Keywords
                                        </label>
                                        <input type="text" 
                                               name="sections[{{ $key }}][meta][meta_keywords]" 
                                               id="sections_{{ $key }}_meta_keywords"
                                               value="{{ old("sections.{$key}.meta.meta_keywords", $content->meta['meta_keywords'] ?? '') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                               placeholder="web developer, designer, portfolio">
                                        <p class="text-xs text-gray-500 mt-1">Comma-separated keywords</p>
                                    </div>
                                    
                                    <div>
                                        <label for="sections_{{ $key }}_meta_author" class="block text-sm font-medium text-gray-700 mb-2">
                                            Author Name
                                        </label>
                                        <input type="text" 
                                               name="sections[{{ $key }}][meta][meta_author]" 
                                               id="sections_{{ $key }}_meta_author"
                                               value="{{ old("sections.{$key}.meta.meta_author", $content->meta['meta_author'] ?? '') }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                               placeholder="Your Name">
                                        <p class="text-xs text-gray-500 mt-1">Site author for meta tags</p>
                                    </div>
                                </div>
                            </div>
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
                Save Branding Settings
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const colorInput = document.getElementById('sections_site_branding_brand_color');
    const colorText = colorInput.nextElementSibling;
    
    if (colorInput && colorText) {
        colorInput.addEventListener('input', function() {
            colorText.value = this.value;
        });
    }
    
    
    const logoUpload = document.getElementById('logo_upload');
    const faviconUpload = document.getElementById('favicon_upload');
    
    if (logoUpload) {
        logoUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                   
                    console.log('Logo selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    if (faviconUpload) {
        faviconUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                console.log('Favicon selected:', file.name);
            }
        });
    }
});
</script>
@endsection