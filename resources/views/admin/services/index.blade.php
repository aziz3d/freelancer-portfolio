@extends('layouts.admin')

@section('title', 'Services Management')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Services Management</h1>
    <div class="flex space-x-3">
        <a href="{{ route('admin.content.services-settings') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Section Settings
        </a>
        <a href="{{ route('admin.services.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Add New Service
        </a>
    </div>
</div>

@if($services->count() > 0)
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <form id="bulk-action-form" method="POST" action="{{ route('admin.services.bulk-action') }}">
            @csrf
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="select-all" class="text-sm text-gray-700">Select All</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select name="action" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                            <option value="">Bulk Actions</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">Deactivate</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                            Apply
                        </button>
                    </div>
                </div>
            </div>

            <ul class="divide-y divide-gray-200">
                @foreach($services as $service)
                    <li class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <input type="checkbox" name="services[]" value="{{ $service->id }}" 
                                       class="service-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $service->title }}</h3>
                                        <p class="text-sm text-gray-500">{{ Str::limit($service->description, 100) }}</p>
                                        <div class="mt-1 flex items-center space-x-4 text-xs text-gray-500">
                                            <span>Icon: {{ $service->icon }}</span>
                                            <span>Sort Order: {{ $service->sort_order }}</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                        @if($service->features && count($service->features) > 0)
                                            <div class="mt-2">
                                                <span class="text-xs text-gray-500">Features: </span>
                                                @foreach(array_slice($service->features, 0, 3) as $feature)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                                        {{ $feature }}
                                                    </span>
                                                @endforeach
                                                @if(count($service->features) > 3)
                                                    <span class="text-xs text-gray-500">+{{ count($service->features) - 3 }} more</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.services.show', $service) }}" 
                                   class="text-blue-600 hover:text-blue-900 text-sm font-medium">View</a>
                                <a href="{{ route('admin.services.edit', $service) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" 
                                      class="inline" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </form>
    </div>

    <div class="mt-6">
        {{ $services->links() }}
    </div>
@else
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No services</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by creating a new service.</p>
        <div class="mt-6">
            <a href="{{ route('admin.services.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Add New Service
            </a>
        </div>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.service-checkbox');
    const bulkForm = document.getElementById('bulk-action-form');

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    });

    bulkForm.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.service-checkbox:checked');
        const action = document.querySelector('select[name="action"]').value;
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one service.');
            return;
        }
        
        if (!action) {
            e.preventDefault();
            alert('Please select an action.');
            return;
        }
        
        if (action === 'delete') {
            if (!confirm('Are you sure you want to delete the selected services?')) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection