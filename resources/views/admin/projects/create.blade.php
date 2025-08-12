@extends('layouts.admin')

@section('title', 'Create Project')

@section('content')
<div class="space-y-6">
   
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create New Project</h1>
            <p class="text-gray-600">Add a new project to your portfolio</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Back to Projects
        </a>
    </div>

   
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="space-y-6 p-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              
                <div class="lg:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title"
                           value="{{ old('title') }}"
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-300 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

           
                <div class="lg:col-span-2">
                    <label for="slug" class="block text-sm font-medium text-gray-700">
                        Slug
                        <span class="text-gray-500 text-xs">(Leave empty to auto-generate from title)</span>
                    </label>
                    <input type="text" 
                           name="slug" 
                           id="slug"
                           value="{{ old('slug') }}"
                           placeholder="project-slug"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('slug') border-red-300 @enderror">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" 
                            id="status" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-300 @enderror">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

             
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700">
                        Sort Order
                    </label>
                    <input type="number" 
                           name="sort_order" 
                           id="sort_order"
                           value="{{ old('sort_order', 0) }}"
                           min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sort_order') border-red-300 @enderror">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

             
                <div class="lg:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_featured" 
                               id="is_featured"
                               value="1"
                               {{ old('is_featured') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                            Feature this project on homepage
                        </label>
                    </div>
                    @error('is_featured')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

           
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">
                    Description
                </label>
                <textarea name="description" 
                          id="description"
                          rows="3"
                          placeholder="Brief description of the project..."
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

          
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">
                    Content
                </label>
                <textarea name="content" 
                          id="content"
                          rows="10"
                          placeholder="Detailed project content, features, challenges, etc..."
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('content') border-red-300 @enderror">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

         
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
             
                <x-image-upload 
                    name="thumbnail"
                    label="Thumbnail Image"
                    help="Upload a high-quality image that represents this project (PNG, JPG, GIF, WebP up to 5MB)"
                />

             
                <x-image-upload 
                    name="project_images"
                    label="Project Images"
                    :multiple="true"
                    help="Upload multiple images for the project gallery (PNG, JPG, GIF, WebP up to 5MB each)"
                />
            </div>

          
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
               
                <div>
                    <label for="project_url" class="block text-sm font-medium text-gray-700">
                        Project URL
                    </label>
                    <input type="url" 
                           name="project_url" 
                           id="project_url"
                           value="{{ old('project_url') }}"
                           placeholder="https://example.com"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('project_url') border-red-300 @enderror">
                    @error('project_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    <label for="github_url" class="block text-sm font-medium text-gray-700">
                        GitHub URL
                    </label>
                    <input type="url" 
                           name="github_url" 
                           id="github_url"
                           value="{{ old('github_url') }}"
                           placeholder="https://github.com/username/repo"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('github_url') border-red-300 @enderror">
                    @error('github_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

           
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
               
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700">
                        Tags
                    </label>
                    <input type="text" 
                           name="tags" 
                           id="tags"
                           value="{{ old('tags') }}"
                           placeholder="web design, portfolio, responsive"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('tags') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Separate tags with commas</p>
                    @error('tags')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    <label for="technologies" class="block text-sm font-medium text-gray-700">
                        Technologies
                    </label>
                    <input type="text" 
                           name="technologies" 
                           id="technologies"
                           value="{{ old('technologies') }}"
                           placeholder="Laravel, Vue.js, Tailwind CSS"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('technologies') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Separate technologies with commas</p>
                    @error('technologies')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

          
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.projects.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Create Project
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    
    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });

    
    slugInput.addEventListener('input', function() {
        if (this.value !== '') {
            delete this.dataset.autoGenerated;
        }
    });

    
    const contentTextarea = document.getElementById('content');
    
    
    const toolbar = document.createElement('div');
    toolbar.className = 'flex space-x-2 mb-2 p-2 bg-gray-50 rounded-t-md border border-b-0 border-gray-300';
    
    const buttons = [
        { label: 'B', action: () => wrapText('**', '**'), title: 'Bold' },
        { label: 'I', action: () => wrapText('*', '*'), title: 'Italic' },
        { label: 'Link', action: () => wrapText('[', '](url)'), title: 'Link' },
        { label: 'Code', action: () => wrapText('`', '`'), title: 'Code' }
    ];

    buttons.forEach(btn => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'px-2 py-1 text-xs bg-white border border-gray-300 rounded hover:bg-gray-100';
        button.textContent = btn.label;
        button.title = btn.title;
        button.addEventListener('click', btn.action);
        toolbar.appendChild(button);
    });

    contentTextarea.parentNode.insertBefore(toolbar, contentTextarea);
    contentTextarea.className += ' rounded-t-none';

    function wrapText(before, after) {
        const start = contentTextarea.selectionStart;
        const end = contentTextarea.selectionEnd;
        const text = contentTextarea.value;
        const selectedText = text.substring(start, end);
        
        const newText = text.substring(0, start) + before + selectedText + after + text.substring(end);
        contentTextarea.value = newText;
        
        
        const newCursorPos = start + before.length + selectedText.length + after.length;
        contentTextarea.setSelectionRange(newCursorPos, newCursorPos);
        contentTextarea.focus();
    }
});
</script>
@endsection