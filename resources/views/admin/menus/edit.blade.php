@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Menu</h1>
        <a href="{{ route('admin.menus.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Back to Menus
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg">
        <form method="POST" action="{{ route('admin.menus.update', $menu) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Menu Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $menu->title) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-300 @enderror"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $menu->slug) }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('slug') border-red-300 @enderror"
                           required>
                    <p class="mt-1 text-xs text-gray-500">URL-friendly version</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-300 @enderror">{{ old('description', $menu->description) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Optional description for admin reference</p>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
                    <select name="icon" id="icon" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('icon') border-red-300 @enderror">
                        <option value="">No icon</option>
                        @foreach($availableIcons as $value => $label)
                            <option value="{{ $value }}" {{ old('icon', $menu->icon) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $menu->sort_order) }}" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sort_order') border-red-300 @enderror">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Menu Destination</h3>
                
                @php
                    $currentDestination = 'route';
                    if ($menu->url) {
                        $currentDestination = 'url';
                    } elseif ($menu->page) {
                        $currentDestination = 'page';
                    }
                @endphp
                
                <div class="space-y-4">
                    <div>
                        <label class="flex items-center">
                            <input type="radio" name="destination_type" value="route" class="destination-radio" 
                                   {{ old('destination_type', $currentDestination) === 'route' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm font-medium text-gray-700">Link to existing route</span>
                        </label>
                        <div class="mt-2 ml-6 destination-field" id="route-field">
                            <select name="route_name" id="route_name" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach($availableRoutes as $value => $label)
                                    <option value="{{ $value }}" {{ old('route_name', $menu->route_name) === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="radio" name="destination_type" value="url" class="destination-radio"
                                   {{ old('destination_type', $currentDestination) === 'url' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm font-medium text-gray-700">Link to custom URL</span>
                        </label>
                        <div class="mt-2 ml-6 destination-field hidden" id="url-field">
                            <input type="url" name="url" id="url" value="{{ old('url', $menu->url) }}" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="https://example.com">
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="radio" name="destination_type" value="page" class="destination-radio"
                                   {{ old('destination_type', $currentDestination) === 'page' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm font-medium text-gray-700">Create/Edit page</span>
                        </label>
                        <div class="mt-2 ml-6 destination-field hidden" id="page-field">
                            <div class="space-y-4">
                                <div>
                                    <label for="page_content" class="block text-sm font-medium text-gray-700">Page Content</label>
                                    <textarea name="page_content" id="page_content" rows="8" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="Enter the content for the page...">{{ old('page_content', $menu->page?->content) }}</textarea>
                                </div>
                                
                                <div>
                                    <label for="page_excerpt" class="block text-sm font-medium text-gray-700">Page Excerpt</label>
                                    <textarea name="page_excerpt" id="page_excerpt" rows="2" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="Brief description of the page...">{{ old('page_excerpt', $menu->page?->excerpt) }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $menu->page?->meta_title) }}" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                               placeholder="SEO title (optional)">
                                    </div>
                                    
                                    <div>
                                        <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" rows="2" 
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                  placeholder="SEO description (optional)">{{ old('meta_description', $menu->page?->meta_description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center">
                        <div class="flex items-center h-5">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                   {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_active" class="font-medium text-gray-700">Active</label>
                            <p class="text-gray-500">Show this menu in the navigation</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex items-center h-5">
                            <input type="hidden" name="opens_in_new_tab" value="0">
                            <input type="checkbox" name="opens_in_new_tab" id="opens_in_new_tab" value="1" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                   {{ old('opens_in_new_tab', $menu->opens_in_new_tab) ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="opens_in_new_tab" class="font-medium text-gray-700">Open in New Tab</label>
                            <p class="text-gray-500">Open link in a new browser tab</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.menus.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                    Update Menu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const destinationRadios = document.querySelectorAll('.destination-radio');
    const destinationFields = document.querySelectorAll('.destination-field');

    
    titleInput.addEventListener('input', function() {
        const currentSlug = slugInput.value;
        const titleSlug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        
        
        if (!currentSlug || currentSlug === titleSlug) {
            slugInput.value = titleSlug;
        }
    });

    
    destinationRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            destinationFields.forEach(field => field.classList.add('hidden'));
            
            const targetField = document.getElementById(this.value + '-field');
            if (targetField) {
                targetField.classList.remove('hidden');
            }
        });
    });

  
    const checkedRadio = document.querySelector('.destination-radio:checked');
    if (checkedRadio) {
        checkedRadio.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection