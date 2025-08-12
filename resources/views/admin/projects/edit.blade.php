@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Project</h1>
            <p class="text-gray-600">Update project information</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('projects.show', $project) }}" 
               target="_blank"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                View Live
            </a>
            <a href="{{ route('admin.projects.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Back to Projects
            </a>
        </div>
    </div>

   
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
           
                <div class="lg:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title"
                           value="{{ old('title', $project->title) }}"
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
                           value="{{ old('slug', $project->slug) }}"
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
                        <option value="draft" {{ old('status', $project->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $project->status) === 'published' ? 'selected' : '' }}>Published</option>
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
                           value="{{ old('sort_order', $project->sort_order) }}"
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
                               {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}
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
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-300 @enderror">{{ old('description', $project->description) }}</textarea>
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
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('content') border-red-300 @enderror">{{ old('content', $project->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

           
            @if($project->thumbnail || ($project->images && count($project->images) > 0))
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Current Images</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @if($project->thumbnail)
                            <div class="relative">
                                <img src="{{ asset(str_contains($project->thumbnail, '/') ? $project->thumbnail : 'images/' . $project->thumbnail) }}" 
                                     alt="Thumbnail" 
                                     class="w-full h-24 object-cover rounded-lg">
                                <div class="absolute top-1 left-1 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                    Thumbnail
                                </div>
                            </div>
                        @endif
                        
                        @if($project->images)
                            @foreach($project->images as $image)
                                <div class="relative">
                                    <img src="{{ asset(str_contains($image, '/') ? $image : 'images/' . $image) }}" 
                                         alt="Project image" 
                                         class="w-full h-24 object-cover rounded-lg">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Upload new images below to replace current ones
                    </p>
                </div>
            @endif

           
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
             
                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700">
                        Thumbnail Image
                        @if($project->thumbnail)
                            <span class="text-gray-500 text-xs">(Upload new to replace current)</span>
                        @endif
                    </label>
                    <input type="file" 
                           name="thumbnail" 
                           id="thumbnail"
                           accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('thumbnail') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

               
                <div>
                    <label for="project_images" class="block text-sm font-medium text-gray-700">
                        Project Images
                        @if($project->images && count($project->images) > 0)
                            <span class="text-gray-500 text-xs">(Upload new to replace current)</span>
                        @endif
                    </label>
                    <input type="file" 
                           name="project_images[]" 
                           id="project_images"
                           accept="image/*"
                           multiple
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('project_images.*') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Multiple images allowed, PNG, JPG, GIF up to 2MB each</p>
                    @error('project_images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

           
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              
                <div>
                    <label for="project_url" class="block text-sm font-medium text-gray-700">
                        Project URL
                    </label>
                    <input type="url" 
                           name="project_url" 
                           id="project_url"
                           value="{{ old('project_url', $project->project_url) }}"
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
                           value="{{ old('github_url', $project->github_url) }}"
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
                           value="{{ old('tags', $project->tags ? implode(', ', $project->tags) : '') }}"
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
                           value="{{ old('technologies', $project->technologies ? implode(', ', $project->technologies) : '') }}"
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
                    Update Project
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const originalSlug = slugInput.value;

   
    titleInput.addEventListener('input', function() {
        const autoGeneratedSlug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');

       
        if (!slugInput.value || slugInput.dataset.autoGenerated || slugInput.value === originalSlug) {
            slugInput.value = autoGeneratedSlug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });

   
    slugInput.addEventListener('input', function() {
        if (this.value !== originalSlug) {
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