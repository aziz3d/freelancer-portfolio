@extends('layouts.app')

@section('title', 'Projects - ' . ($siteBranding['title'] ?? 'Aziz Khan'))
@section('meta_description', 'Browse my portfolio of web development and 3D modeling projects. Featuring Laravel applications, 3ds Max models, and creative digital solutions.')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            @if(isset($pageTitle['meta']['subtitle']) && !empty($pageTitle['meta']['subtitle']))
                <p class="text-lg text-primary-600 font-medium mb-2">{{ $pageTitle['meta']['subtitle'] }}</p>
            @endif
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $pageTitle['title'] ?? 'My Projects' }}</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $pageTitle['content'] ?? 'Explore my portfolio of web development and 3D modeling projects. Each project represents a unique challenge and creative solution.' }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-soft p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <h2 class="text-lg font-semibold text-gray-900">Filter Projects</h2>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label for="technology-filter" class="block text-sm font-medium text-gray-700 mb-2">
                            Filter by Technology
                        </label>
                        <select id="technology-filter" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All Technologies</option>
                            @foreach($technologies as $technology)
                                <option value="{{ $technology }}" 
                                        {{ request('technology') === $technology ? 'selected' : '' }}>
                                    {{ $technology }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1">
                        <label for="tag-filter" class="block text-sm font-medium text-gray-700 mb-2">
                            Filter by Tag
                        </label>
                        <select id="tag-filter" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All Tags</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag }}" 
                                        {{ request('tag') === $tag ? 'selected' : '' }}>
                                    {{ $tag }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if(request('technology') || request('tag'))
                        <div class="flex items-end">
                            <a href="{{ route('projects.index') }}" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors duration-200">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            @if(request('technology') || request('tag'))
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-700">Active filters:</span>
                        @if(request('technology'))
                            <span class="px-3 py-1 bg-primary-100 text-primary-700 text-sm rounded-full">
                                Technology: {{ request('technology') }}
                            </span>
                        @endif
                        @if(request('tag'))
                            <span class="px-3 py-1 bg-secondary-100 text-secondary-700 text-sm rounded-full">
                                Tag: {{ request('tag') }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        @if($projects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                    <x-project-card :project="$project" />
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No projects found</h3>
                    <p class="mt-2 text-gray-500">
                        @if(request('technology') || request('tag'))
                            No projects match your current filters. Try adjusting your search criteria.
                        @else
                            There are no published projects available at the moment.
                        @endif
                    </p>
                    @if(request('technology') || request('tag'))
                        <a href="{{ route('projects.index') }}" 
                           class="mt-4 inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors duration-200">
                            View All Projects
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const technologyFilter = document.getElementById('technology-filter');
    const tagFilter = document.getElementById('tag-filter');
    
    function updateFilters() {
        const technology = technologyFilter.value;
        const tag = tagFilter.value;
        
        const url = new URL(window.location.href);
        url.searchParams.delete('technology');
        url.searchParams.delete('tag');
        
        if (technology) {
            url.searchParams.set('technology', technology);
        }
        if (tag) {
            url.searchParams.set('tag', tag);
        }
        
        window.location.href = url.toString();
    }
    
    technologyFilter.addEventListener('change', updateFilters);
    tagFilter.addEventListener('change', updateFilters);
});
</script>
@endpush
@endsection