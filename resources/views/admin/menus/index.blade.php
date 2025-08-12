@extends('layouts.admin')

@section('title', 'Menu Management')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Menu Management</h1>
        <a href="{{ route('admin.menus.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Add New Menu
        </a>
    </div>



    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        @if($menus->count() > 0)
            <form id="bulk-action-form" method="POST" action="{{ route('admin.menus.bulk-action') }}"
                  onsubmit="console.log('Form submitting to:', this.action)">
                @csrf
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300">
                            <label for="select-all" class="text-sm text-gray-600">Select All</label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <select name="action" class="rounded-md border-gray-300 text-sm">
                                <option value="">Bulk Actions</option>
                                <option value="activate">Activate</option>
                                <option value="deactivate">Deactivate</option>
                                <option value="delete">Delete</option>
                            </select>
                            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-md text-sm">
                                Apply
                            </button>
                            <a href="{{ route('admin.menus.test-bulk') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded-md text-xs ml-2">
                                Test Route
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <span class="sr-only">Select</span>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Menu
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($menus as $menu)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="menus[]" value="{{ $menu->id }}" 
                                               class="menu-checkbox rounded border-gray-300">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($menu->icon)
                                                <div class="flex-shrink-0 h-8 w-8 mr-3">
                                                    <div class="h-8 w-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            @switch($menu->icon)
                                                                @case('home')
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                                    @break
                                                                @case('user')
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                    @break
                                                                @default
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                                            @endswitch
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $menu->title }}
                                                    @if($menu->is_system)
                                                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            System
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $menu->slug }}</div>
                                                @if($menu->description)
                                                    <div class="text-xs text-gray-400 mt-1">{{ Str::limit($menu->description, 50) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($menu->route_name)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Route
                                            </span>
                                            <div class="text-xs text-gray-400 mt-1">{{ $menu->route_name }}</div>
                                        @elseif($menu->url)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                URL
                                            </span>
                                            <div class="text-xs text-gray-400 mt-1">{{ Str::limit($menu->url, 30) }}</div>
                                        @elseif($menu->page)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Page
                                            </span>
                                            <div class="text-xs text-gray-400 mt-1">{{ $menu->page->title }}</div>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                None
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $menu->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $menu->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $menu->sort_order }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.menus.show', $menu) }}" 
                                               class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('admin.menus.edit', $menu) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('Are you sure you want to delete this menu?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $menus->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No menus</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new menu.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.menus.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Add New Menu
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.menu-checkbox');
    const bulkForm = document.getElementById('bulk-action-form');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

   
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            const someChecked = Array.from(checkboxes).some(cb => cb.checked);
            
            if (selectAll) {
                selectAll.checked = allChecked;
                selectAll.indeterminate = someChecked && !allChecked;
            }
        });
    });

    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const actionSelect = this.querySelector('select[name="action"]');
            const action = actionSelect ? actionSelect.value : '';
            const checkedBoxes = document.querySelectorAll('.menu-checkbox:checked');
            
            console.log('=== BULK ACTION FORM SUBMISSION ===');
            console.log('Bulk action:', action);
            console.log('Checked boxes:', checkedBoxes.length);
            console.log('Menu IDs:', Array.from(checkedBoxes).map(cb => cb.value));
            console.log('Form action URL:', this.action);
            console.log('Form method:', this.method);
            
            if (!action) {
                e.preventDefault();
                alert('Please select an action.');
                return false;
            }
            
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one menu.');
                return false;
            }
            
            let confirmMessage = '';
            switch(action) {
                case 'delete':
                    confirmMessage = 'Are you sure you want to delete the selected menus?';
                    break;
                case 'deactivate':
                    confirmMessage = 'Are you sure you want to deactivate the selected menus?';
                    break;
                case 'activate':
                    confirmMessage = 'Are you sure you want to activate the selected menus?';
                    break;
            }
            
            if (confirmMessage && !confirm(confirmMessage)) {
                e.preventDefault();
                return false;
            }
            
            console.log('Form submission proceeding...');
            return true;
        });
    }
});
</script>
@endsection