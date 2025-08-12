@extends('layouts.admin')

@section('title', 'Blog Management')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Blog Management</h1>
            <p class="text-gray-600">Manage your blog posts and articles</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.content.blog-settings') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Section Settings
            </a>
            <a href="{{ route('admin.blog.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Create New Post
            </a>
        </div>
    </div>

   
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.blog.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
             
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search posts..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

             
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" 
                            name="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Statuses</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                </div>

           
                <div>
                    <label for="tag" class="block text-sm font-medium text-gray-700 mb-1">Tag</label>
                    <select id="tag" 
                            name="tag" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Tags</option>
                        @foreach($allTags as $tag)
                            <option value="{{ $tag }}" {{ request('tag') === $tag ? 'selected' : '' }}>
                                {{ $tag }}
                            </option>
                        @endforeach
                    </select>
                </div>

              
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select id="sort" 
                            name="sort" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="published_at" {{ request('sort') === 'published_at' ? 'selected' : '' }}>Published Date</option>
                        <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
                        <option value="status" {{ request('sort') === 'status' ? 'selected' : '' }}>Status</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex space-x-2">
                    <button type="submit" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.blog.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                        Clear
                    </a>
                </div>
                
                <div class="flex items-center space-x-2">
                    <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
                    <button type="button" 
                            onclick="toggleSortDirection()"
                            class="text-gray-500 hover:text-gray-700">
                        @if(request('direction', 'desc') === 'desc')
                            ↓ Descending
                        @else
                            ↑ Ascending
                        @endif
                    </button>
                </div>
            </div>
        </form>
    </div>

   
    <form id="bulk-form" method="POST" action="{{ route('admin.blog.bulk-action') }}">
        @csrf
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-3 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   id="select-all" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Select All</span>
                        </label>
                        <span id="selected-count" class="text-sm text-gray-500">0 selected</span>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <select name="action" 
                                id="bulk-action" 
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Bulk Actions</option>
                            <option value="publish">Publish</option>
                            <option value="draft">Move to Draft</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="button" 
                                onclick="executeBulkAction()" 
                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                            Apply
                        </button>
                    </div>
                </div>
            </div>

           
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Post
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tags
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Published
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($blogs as $blog)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" 
                                           name="selected_blogs[]" 
                                           value="{{ $blog->id }}" 
                                           class="blog-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start space-x-3">
                                        @if($blog->thumbnail)
                                            <img src="{{ asset($blog->thumbnail) }}" 
                                                 alt="{{ $blog->title }}" 
                                                 class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-sm font-medium text-gray-900 truncate">
                                                {{ $blog->title }}
                                            </h3>
                                            @if($blog->excerpt)
                                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                                    {{ Str::limit($blog->excerpt, 100) }}
                                                </p>
                                            @endif
                                            <p class="text-xs text-gray-400 mt-1">
                                                Created: {{ $blog->created_at->format('M j, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                                <td class="px-6 py-4">
                                    @if($blog->tags && count($blog->tags) > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($blog->tags, 0, 3) as $tag)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                            @if(count($blog->tags) > 3)
                                                <span class="text-xs text-gray-500">+{{ count($blog->tags) - 3 }} more</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">No tags</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($blog->published_at)
                                        {{ $blog->published_at->format('M j, Y') }}
                                        @if($blog->isScheduled())
                                            <br><span class="text-xs text-yellow-600">{{ $blog->published_at->format('g:i A') }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">Not published</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.blog.show', $blog) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            View
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $blog) }}" 
                                           class="text-indigo-600 hover:text-indigo-900">
                                            Edit
                                        </a>
                                        <button type="button" 
                                                onclick="deleteBlog({{ $blog->id }})" 
                                                class="text-red-600 hover:text-red-900">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No blog posts</h3>
                                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new blog post.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('admin.blog.create') }}" 
                                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                                Create New Post
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

       
            @if($blogs->hasPages())
                <div class="px-6 py-3 border-t border-gray-200">
                    {{ $blogs->links() }}
                </div>
            @endif
        </div>
    </form>
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
                    Are you sure you want to delete this blog post? This action cannot be undone.
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
function toggleSortDirection() {
    const directionInput = document.querySelector('input[name="direction"]');
    const currentDirection = directionInput.value;
    directionInput.value = currentDirection === 'desc' ? 'asc' : 'desc';
    directionInput.closest('form').submit();
}


document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.blog-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateSelectedCount();
});

 
function updateSelectedCount() {
    const selectedCheckboxes = document.querySelectorAll('.blog-checkbox:checked');
    const count = selectedCheckboxes.length;
    document.getElementById('selected-count').textContent = count + ' selected';
}


document.querySelectorAll('.blog-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
});


function executeBulkAction() {
    const selectedCheckboxes = document.querySelectorAll('.blog-checkbox:checked');
    const action = document.getElementById('bulk-action').value;
    
    if (selectedCheckboxes.length === 0) {
        alert('Please select at least one blog post.');
        return;
    }
    
    if (!action) {
        alert('Please select an action.');
        return;
    }
    
    if (action === 'delete') {
        if (!confirm('Are you sure you want to delete the selected blog posts? This action cannot be undone.')) {
            return;
        }
    }
    
    document.getElementById('bulk-form').submit();
}


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