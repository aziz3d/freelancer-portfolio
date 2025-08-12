@extends('layouts.admin')

@section('title', 'View Blog Post')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $blog->title }}</h1>
            <div class="flex items-center space-x-4 mt-2">
                @if($blog->isDraft())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Draft
                    </span>
                @elseif($blog->isScheduled())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Scheduled for {{ $blog->published_at->format('M j, Y \a\t g:i A') }}
                    </span>
                @elseif($blog->isPublished())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Published on {{ $blog->published_at->format('M j, Y \a\t g:i A') }}
                    </span>
                @endif
                <span class="text-sm text-gray-500">
                    Created {{ $blog->created_at->format('M j, Y') }}
                </span>
            </div>
        </div>
        <div class="flex space-x-2">
            @if($blog->isPublished())
                <a href="{{ route('blog.show', $blog) }}" 
                   target="_blank"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    View Live
                </a>
            @endif
            <a href="{{ route('admin.blog.edit', $blog) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Edit Post
            </a>
            <a href="{{ route('admin.blog.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Back to Blog
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @if($blog->thumbnail)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <img src="{{ asset($blog->thumbnail) }}" 
                         alt="{{ $blog->title }}" 
                         class="w-full h-64 object-cover">
                </div>
            @endif

         
            @if($blog->excerpt)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Excerpt</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $blog->excerpt }}</p>
                </div>
            @endif

         
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Content</h2>
                <div class="prose prose-lg max-w-none">
                    {!! $blog->rendered_content !!}
                </div>
            </div>
        </div>

      
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Post Details</h2>
                
                <div class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Slug</dt>
                        <dd class="text-sm text-gray-900 font-mono bg-gray-50 px-2 py-1 rounded">{{ $blog->slug }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="text-sm text-gray-900">
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
                        </dd>
                    </div>
                    
                    @if($blog->published_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                {{ $blog->isScheduled() ? 'Scheduled For' : 'Published On' }}
                            </dt>
                            <dd class="text-sm text-gray-900">{{ $blog->published_at->format('M j, Y \a\t g:i A') }}</dd>
                        </div>
                    @endif
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="text-sm text-gray-900">{{ $blog->created_at->format('M j, Y \a\t g:i A') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="text-sm text-gray-900">{{ $blog->updated_at->format('M j, Y \a\t g:i A') }}</dd>
                    </div>
                </div>
            </div>

          
            @if($blog->tags && count($blog->tags) > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Tags</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($blog->tags as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

       
            @if($blog->meta_title || $blog->meta_description)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">SEO Information</h2>
                    
                    @if($blog->meta_title)
                        <div class="mb-4">
                            <dt class="text-sm font-medium text-gray-500 mb-1">Meta Title</dt>
                            <dd class="text-sm text-gray-900">{{ $blog->meta_title }}</dd>
                            <p class="text-xs text-gray-500 mt-1">{{ strlen($blog->meta_title) }}/60 characters</p>
                        </div>
                    @endif
                    
                    @if($blog->meta_description)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-1">Meta Description</dt>
                            <dd class="text-sm text-gray-900">{{ $blog->meta_description }}</dd>
                            <p class="text-xs text-gray-500 mt-1">{{ strlen($blog->meta_description) }}/160 characters</p>
                        </div>
                    @endif
                </div>
            @endif

          
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                
                <div class="space-y-3">
                    @if($blog->isDraft())
                        <form method="POST" action="{{ route('admin.blog.update', $blog) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="published">
                            <input type="hidden" name="published_at" value="{{ now() }}">
                            <input type="hidden" name="title" value="{{ $blog->title }}">
                            <input type="hidden" name="content" value="{{ $blog->content }}">
                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                Publish Now
                            </button>
                        </form>
                    @elseif($blog->isPublished())
                        <form method="POST" action="{{ route('admin.blog.update', $blog) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="draft">
                            <input type="hidden" name="published_at" value="">
                            <input type="hidden" name="title" value="{{ $blog->title }}">
                            <input type="hidden" name="content" value="{{ $blog->content }}">
                            <button type="submit" 
                                    class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                Move to Draft
                            </button>
                        </form>
                    @endif
                    
                    <button type="button" 
                            onclick="deleteBlog({{ $blog->id }})" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                        Delete Post
                    </button>
                </div>
            </div>

        
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Word Count</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ str_word_count(strip_tags($blog->content)) }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Character Count</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ strlen(strip_tags($blog->content)) }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Reading Time</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-2">Delete Blog Post</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete "{{ $blog->title }}"? This action cannot be undone.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="delete-form" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Delete
                    </button>
                </form>
                <button onclick="closeDeleteModal()" 
                        class="ml-3 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function deleteBlog(blogId) {
    const modal = document.getElementById('delete-modal');
    const form = document.getElementById('delete-form');
    form.action = `/admin/blog/${blogId}`;
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('delete-modal').classList.add('hidden');
}

document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection