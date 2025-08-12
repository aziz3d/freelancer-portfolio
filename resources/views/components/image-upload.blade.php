@props([
    'name' => 'image',
    'label' => 'Upload Image',
    'multiple' => false,
    'required' => false,
    'accept' => 'image/jpeg,image/jpg,image/png,image/gif,image/webp',
    'maxSize' => '5MB',
    'currentImage' => null,
    'help' => null
])

<div class="form-group">
    <label for="{{ $name }}" class="label">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    @if($help)
        <p class="text-sm text-gray-600 mb-3">{{ $help }}</p>
    @endif
    
    <div class="image-drop-zone" onclick="document.getElementById('{{ $name }}').click()">
        <input 
            type="file" 
            id="{{ $name }}" 
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            accept="{{ $accept }}"
            {{ $multiple ? 'multiple' : '' }}
            {{ $required ? 'required' : '' }}
            class="hidden"
            {{ $attributes->except(['name', 'label', 'multiple', 'required', 'accept', 'maxSize', 'currentImage', 'help']) }}
        >
        
        <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            
            <p class="text-sm text-gray-600 mb-2">
                <span class="font-medium text-primary-600">Click to upload</span> or drag and drop
            </p>
            
            <p class="text-xs text-gray-500">
                PNG, JPG, GIF, WebP up to {{ $maxSize }}
                @if($multiple)
                    (Multiple files allowed)
                @endif
            </p>
        </div>
    </div>
    
    @if($currentImage)
        <div class="mt-4">
            <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
            <div class="inline-block">
                <x-optimized-image 
                    :path="$currentImage" 
                    alt="Current image" 
                    class="w-32 h-32 object-cover rounded-lg border"
                    thumbnail="true"
                />
            </div>
        </div>
    @endif
    
    <div class="image-preview mt-4"></div>
    
    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    
    @if($multiple)
        @error($name . '.*')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    @endif
</div>