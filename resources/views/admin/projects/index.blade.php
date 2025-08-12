@extends('layouts.admin')

@section('title', 'Projects Management')

@section('content')
<div class="space-y-6">
   
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Projects Management</h1>
            <p class="text-gray-600">Manage your portfolio projects</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.content.projects-settings') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Section Settings
            </a>
            <a href="{{ route('admin.projects.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Add New Project
            </a>
        </div>
    </div>

  
    <div class="bg-white p-4 rounded-lg shadow">
        <form method="GET" action="{{ route('admin.projects.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" 
                       name="search" 
                       id="search"
                       value="{{ request('search') }}"
                       placeholder="Search by title, description, tags, or technologies..."
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div>
                <label for="featured" class="block text-sm font-medium text-gray-700">Featured</label>
                <select name="featured" id="featured" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Projects</option>
                    <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Featured Only</option>
                    <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Not Featured</option>
                </select>
            </div>

            <div>
                <label for="technology" class="block text-sm font-medium text-gray-700">Technology</label>
                <select name="technology" id="technology" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Technologies</option>
                    @foreach($technologies as $tech)
                        <option value="{{ $tech }}" {{ request('technology') === $tech ? 'selected' : '' }}>
                            {{ $tech }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Filter
                </button>
                <a href="{{ route('admin.projects.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                    Clear
                </a>
            </div>
        </form>
    </div>

 
    <div class="bg-white p-4 rounded-lg shadow">
        <form id="bulk-action-form" method="POST" action="{{ route('admin.projects.bulk-action') }}">
            @csrf
            <div class="flex items-center space-x-4">
                <div>
                    <label for="bulk-action" class="block text-sm font-medium text-gray-700">Bulk Actions</label>
                    <select name="action" id="bulk-action" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Action</option>
                        <option value="publish">Publish</option>
                        <option value="unpublish">Unpublish</option>
                        <option value="feature">Feature</option>
                        <option value="unfeature">Unfeature</option>
                        <option value="delete" class="text-red-600">Delete</option>
                    </select>
                </div>
                <div class="pt-6">
                    <button type="submit" 
                            id="bulk-action-btn"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        Apply
                    </button>
                </div>
            </div>
        </form>
    </div>

  
    <div class="bg-white shadow rounded-lg overflow-hidden">
        @if($projects->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Project
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Featured
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Technologies
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($projects as $project)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <input type="checkbox" 
                                       name="projects[]" 
                                       value="{{ $project->id }}" 
                                       class="project-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($project->thumbnail)
                                        <img src="{{ asset(str_contains($project->thumbnail, '/') ? $project->thumbnail : 'images/' . $project->thumbnail) }}" 
                                             alt="{{ $project->title }}"
                                             class="h-12 w-12 rounded-lg object-cover mr-4">
                                    @else
                                        <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $project->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($project->description, 50) }}</div>
                                        @if($project->tags && count($project->tags) > 0)
                                            <div class="mt-1">
                                                @foreach(array_slice($project->tags, 0, 3) as $tag)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                                        {{ $tag }}
                                                    </span>
                                                @endforeach
                                                @if(count($project->tags) > 3)
                                                    <span class="text-xs text-gray-500">+{{ count($project->tags) - 3 }} more</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($project->is_featured)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Featured
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($project->technologies && count($project->technologies) > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($project->technologies, 0, 2) as $tech)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $tech }}
                                            </span>
                                        @endforeach
                                        @if(count($project->technologies) > 2)
                                            <span class="text-xs text-gray-500">+{{ count($project->technologies) - 2 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $project->created_at->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.projects.show', $project) }}" 
                                   class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('admin.projects.edit', $project) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form method="POST" 
                                      action="{{ route('admin.projects.destroy', $project) }}" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

          
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                {{ $projects->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No projects found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new project.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.projects.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Add New Project
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const projectCheckboxes = document.querySelectorAll('.project-checkbox');
    const bulkActionSelect = document.getElementById('bulk-action');
    const bulkActionBtn = document.getElementById('bulk-action-btn');
    const bulkActionForm = document.getElementById('bulk-action-form');

  
    selectAllCheckbox.addEventListener('change', function() {
        projectCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActionButton();
    });

   
    projectCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.project-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === projectCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < projectCheckboxes.length;
            updateBulkActionButton();
        });
    });

   
    function updateBulkActionButton() {
        const checkedCount = document.querySelectorAll('.project-checkbox:checked').length;
        const hasAction = bulkActionSelect.value !== '';
        bulkActionBtn.disabled = checkedCount === 0 || !hasAction;
    }

   
    bulkActionSelect.addEventListener('change', updateBulkActionButton);

   
    bulkActionForm.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.project-checkbox:checked');
        const action = bulkActionSelect.value;
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one project.');
            return;
        }

        if (action === 'delete') {
            if (!confirm(`Are you sure you want to delete ${checkedBoxes.length} project(s)? This action cannot be undone.`)) {
                e.preventDefault();
                return;
            }
        }

       
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'projects[]';
            input.value = checkbox.value;
            this.appendChild(input);
        });
    });
});
</script>
@endsection