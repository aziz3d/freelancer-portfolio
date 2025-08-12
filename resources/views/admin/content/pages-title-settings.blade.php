@extends('layouts.admin')

@section('title', 'Pages Title Settings')

@section('content')
<div class="space-y-6">
   
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Page Title Settings
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Manage hero header titles and descriptions for all your pages
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('admin.content.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Content
            </a>
        </div>
    </div>

   
    <form action="{{ route('admin.content.pages-title-bulk-update') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Page Hero Sections</h3>
                <p class="mt-1 text-sm text-gray-600">Configure the hero header titles and descriptions for each page</p>
            </div>
            
            <div class="p-6 space-y-8">
                @foreach($pagesSections as $key => $sectionName)
                    @php
                        $content = $contents->get($key);
                        $pageName = str_replace('page_titles_', '', $key);
                        $pageDisplayName = ucwords(str_replace('_', ' ', $pageName));
                    @endphp
                    
                    <div class="border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                @if($pageName === 'about')
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @elseif($pageName === 'projects')
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                @elseif($pageName === 'blog')
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @elseif($pageName === 'services')
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                @elseif($pageName === 'contact')
                                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                @else
                                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-3">
                                <h4 class="text-lg font-medium text-gray-900">{{ $pageDisplayName }} Page</h4>
                                <p class="text-sm text-gray-500">Hero section title and description</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6">
                          
                            <div>
                                <label for="sections_{{ $key }}_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Hero Title
                                </label>
                                <input type="text" 
                                       name="sections[{{ $key }}][title]" 
                                       id="sections_{{ $key }}_title"
                                       value="{{ old('sections.' . $key . '.title', $content->title ?? '') }}"
                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter the main hero title for {{ $pageDisplayName }} page">
                            </div>
                            
                           
                            <div>
                                <label for="sections_{{ $key }}_content" class="block text-sm font-medium text-gray-700 mb-2">
                                    Hero Description
                                </label>
                                <textarea name="sections[{{ $key }}][content]" 
                                          id="sections_{{ $key }}_content"
                                          rows="3"
                                          class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Enter the hero description for {{ $pageDisplayName }} page">{{ old('sections.' . $key . '.content', $content->content ?? '') }}</textarea>
                            </div>
                            
                          
                            <div>
                                <label for="sections_{{ $key }}_meta_subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                                    Subtitle <span class="text-gray-500">(optional)</span>
                                </label>
                                <input type="text" 
                                       name="sections[{{ $key }}][meta][subtitle]" 
                                       id="sections_{{ $key }}_meta_subtitle"
                                       value="{{ old('sections.' . $key . '.meta.subtitle', $content->meta['subtitle'] ?? '') }}"
                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter an optional subtitle">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

      
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.content.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Pages Title Settings
            </button>
        </div>
    </form>
</div>
@endsection