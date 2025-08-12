@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Service</h1>
        <a href="{{ route('admin.services.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Back to Services
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg">
        <form method="POST" action="{{ route('admin.services.update', $service) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $service->title) }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-300 @enderror"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-300 @enderror"
                          required>{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
                <select name="icon" id="icon" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('icon') border-red-300 @enderror"
                        required>
                    <option value="">Select an icon</option>
                    @foreach($availableIcons as $value => $label)
                        <option value="{{ $value }}" {{ old('icon', $service->icon) === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('icon')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Features</label>
                <div id="features-container">
                    @php
                        $features = old('features', $service->features ?? []);
                    @endphp
                    @if($features && count($features) > 0)
                        @foreach($features as $index => $feature)
                            <div class="feature-item flex items-center space-x-2 mb-2">
                                <input type="text" name="features[]" value="{{ $feature }}" 
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="Enter feature">
                                <button type="button" class="remove-feature bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm">
                                    Remove
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="feature-item flex items-center space-x-2 mb-2">
                            <input type="text" name="features[]" 
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Enter feature">
                            <button type="button" class="remove-feature bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm">
                                Remove
                            </button>
                        </div>
                    @endif
                </div>
                <button type="button" id="add-feature" class="mt-2 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm">
                    Add Feature
                </button>
                @error('features')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sort_order') border-red-300 @enderror">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                               {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_active" class="font-medium text-gray-700">Active</label>
                        <p class="text-gray-500">Make this service visible on the website</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.services.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md text-sm font-medium">
                    Update Service
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const featuresContainer = document.getElementById('features-container');
    const addFeatureBtn = document.getElementById('add-feature');

    addFeatureBtn.addEventListener('click', function() {
        const featureItem = document.createElement('div');
        featureItem.className = 'feature-item flex items-center space-x-2 mb-2';
        featureItem.innerHTML = `
            <input type="text" name="features[]" 
                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   placeholder="Enter feature">
            <button type="button" class="remove-feature bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm">
                Remove
            </button>
        `;
        featuresContainer.appendChild(featureItem);
    });

    featuresContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-feature')) {
            e.target.closest('.feature-item').remove();
        }
    });
});
</script>
@endsection