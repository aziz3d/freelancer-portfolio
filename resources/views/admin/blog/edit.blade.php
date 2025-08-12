@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Blog Post</h1>
            <p class="text-gray-600">Update your blog article</p>
        </div>
        <div class="flex space-x-2">
            @if($blog->isPublished())
                <a href="{{ route('blog.show', $blog) }}" 
                   target="_blank"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    View Live
                </a>
            @endif
            <a href="{{ route('admin.blog.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Back to Blog
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.blog.update', $blog) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                    
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $blog->title) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                               placeholder="Enter blog post title">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                            Slug
                            <span class="text-gray-500 text-xs">(Leave empty to auto-generate)</span>
                        </label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $blog->slug) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                               placeholder="blog-post-slug">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                            Excerpt
                        </label>
                        <textarea id="excerpt" 
                                  name="excerpt" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('excerpt') border-red-500 @enderror"
                                  placeholder="Brief description of the blog post...">{{ old('excerpt', $blog->excerpt) }}</textarea>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Content</h2>
                    
                    <div class="mb-4">
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="content_type" 
                                       value="html" 
                                       checked
                                       class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Rich Text (HTML)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="content_type" 
                                       value="markdown"
                                       class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Markdown</span>
                            </label>
                        </div>
                    </div>

                  
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <textarea id="content" 
                                  name="content" 
                                  rows="20"
                                  required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror"
                                  placeholder="Write your blog post content here...">{{ old('content', $blog->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                   
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Content Tips</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li><strong>HTML Mode:</strong> Use HTML tags for formatting. Great for rich content with images and styling.</li>
                                        <li><strong>Markdown Mode:</strong> Use Markdown syntax (# for headers, ** for bold, etc.). Perfect for clean, readable text.</li>
                                        <li>Images can be uploaded separately and referenced in your content.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
            <div class="space-y-6">
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Publishing</h2>
                    
                   
                    <div class="mb-4 p-3 bg-gray-50 rounded-md">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Current Status:</span>
                            @if($blog->isDraft())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Draft
                                </span>
                            @elseif($blog->isScheduled())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Scheduled
                                </span>
                            @elseif($blog->isPublished())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Published
                                </span>
                            @endif
                        </div>
                        @if($blog->published_at)
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $blog->isScheduled() ? 'Scheduled for' : 'Published on' }}: 
                                {{ $blog->published_at->format('M j, Y \a\t g:i A') }}
                            </p>
                        @endif
                    </div>
                    
                   
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="draft" {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                  
                    <div class="mb-4" id="published-at-field" style="{{ old('status', $blog->status) === 'published' ? 'display: block;' : 'display: none;' }}">
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                            Publish Date & Time
                        </label>
                        <input type="datetime-local" 
                               id="published_at" 
                               name="published_at" 
                               value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('published_at') border-red-500 @enderror">
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Leave empty to publish immediately</p>
                    </div>
                </div>

                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Featured Image</h2>
                    
                 
                    @if($blog->thumbnail)
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                            <img src="{{ asset($blog->thumbnail) }}" 
                                 alt="{{ $blog->title }}" 
                                 class="w-full h-32 object-cover rounded-md">
                        </div>
                    @endif
                    
                    <div class="mb-4">
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $blog->thumbnail ? 'Replace Image' : 'Thumbnail Image' }}
                        </label>
                        <input type="file" 
                               id="thumbnail" 
                               name="thumbnail" 
                               accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('thumbnail') border-red-500 @enderror">
                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Recommended: 1200x630px, max 2MB</p>
                    </div>

                  
                    <div id="image-preview" class="hidden">
                        <p class="text-sm font-medium text-gray-700 mb-2">New Image Preview:</p>
                        <img id="preview-img" src="" alt="Preview" class="w-full h-32 object-cover rounded-md">
                    </div>
                </div>

             
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Tags</h2>
                    
                    <div class="mb-4">
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                            Tags
                        </label>
                        <input type="text" 
                               id="tags" 
                               name="tags" 
                               value="{{ old('tags') ? (is_array(old('tags')) ? implode(', ', old('tags')) : old('tags')) : (is_array($blog->tags) ? implode(', ', $blog->tags) : ($blog->tags ?? '')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tags') border-red-500 @enderror"
                               placeholder="web development, laravel, php">
                        @error('tags')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Separate tags with commas</p>
                    </div>
                </div>

             
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">SEO Settings</h2>
                    
          
                    <div class="mb-4">
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Title
                        </label>
                        <input type="text" 
                               id="meta_title" 
                               name="meta_title" 
                               value="{{ old('meta_title', $blog->meta_title) }}"
                               maxlength="60"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meta_title') border-red-500 @enderror"
                               placeholder="SEO title for search engines">
                        @error('meta_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Recommended: 50-60 characters</p>
                    </div>

                 
                    <div class="mb-4">
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Description
                        </label>
                        <textarea id="meta_description" 
                                  name="meta_description" 
                                  rows="3"
                                  maxlength="160"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('meta_description') border-red-500 @enderror"
                                  placeholder="Brief description for search engines...">{{ old('meta_description', $blog->meta_description) }}</textarea>
                        @error('meta_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Recommended: 150-160 characters</p>
                    </div>
                </div>

              
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Update Blog Post
                        </button>
                        <button type="button" 
                                onclick="saveDraft()"
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Save as Draft
                        </button>
                        <a href="{{ route('admin.blog.index') }}" 
                           class="block w-full text-center bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>

document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slugField = document.getElementById('slug');
    
    if (!slugField.value || slugField.dataset.autoGenerated) {
        const slug = title
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        
        slugField.value = slug;
        slugField.dataset.autoGenerated = 'true';
    }
});


document.getElementById('slug').addEventListener('input', function() {
    this.dataset.autoGenerated = 'false';
});


document.getElementById('status').addEventListener('change', function() {
    const publishedAtField = document.getElementById('published-at-field');
    if (this.value === 'published') {
        publishedAtField.style.display = 'block';
    } else {
        publishedAtField.style.display = 'none';
    }
});

document.getElementById('thumbnail').addEventListener('change', function() {
    const file = this.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});


function saveDraft() {
    document.getElementById('status').value = 'draft';
    document.querySelector('form').submit();
}


document.addEventListener('DOMContentLoaded', function() {
    const metaTitle = document.getElementById('meta_title');
    const metaDescription = document.getElementById('meta_description');
    
    if (metaTitle) {
        const titleCounter = document.createElement('p');
        titleCounter.className = 'mt-1 text-xs text-gray-500';
        titleCounter.textContent = `${metaTitle.value.length}/60 characters`;
        metaTitle.parentNode.appendChild(titleCounter);
        
        metaTitle.addEventListener('input', function() {
            titleCounter.textContent = `${this.value.length}/60 characters`;
            titleCounter.className = this.value.length > 60 ? 'mt-1 text-xs text-red-500' : 'mt-1 text-xs text-gray-500';
        });
    }
    
    if (metaDescription) {
        const descCounter = document.createElement('p');
        descCounter.className = 'mt-1 text-xs text-gray-500';
        descCounter.textContent = `${metaDescription.value.length}/160 characters`;
        metaDescription.parentNode.appendChild(descCounter);
        
        metaDescription.addEventListener('input', function() {
            descCounter.textContent = `${this.value.length}/160 characters`;
            descCounter.className = this.value.length > 160 ? 'mt-1 text-xs text-red-500' : 'mt-1 text-xs text-gray-500';
        });
    }
});
</script>
@endsection