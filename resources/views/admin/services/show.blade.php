@extends('layouts.admin')

@section('title', 'View Service')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Service Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.services.edit', $service) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Edit Service
            </a>
            <a href="{{ route('admin.services.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Back to Services
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">{{ $service->title }}</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>

        <div class="px-6 py-4 space-y-6">
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Description</h3>
                <p class="text-gray-900">{{ $service->description }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Icon</h3>
                    <div class="flex items-center space-x-2">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-gray-900">{{ $service->icon }}</span>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Sort Order</h3>
                    <p class="text-gray-900">{{ $service->sort_order }}</p>
                </div>
            </div>

            @if($service->features && count($service->features) > 0)
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Features</h3>
                    <div class="space-y-2">
                        @foreach($service->features as $feature)
                            <div class="flex items-center space-x-2">
                                <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-900">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-200">
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Created</h3>
                    <p class="text-gray-900">{{ $service->created_at->format('M d, Y \a\t g:i A') }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Last Updated</h3>
                    <p class="text-gray-900">{{ $service->updated_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                        Delete Service
                    </button>
                </form>

                <div class="flex space-x-3">
                    <a href="{{ route('admin.services.edit', $service) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Edit Service
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection