@extends('layouts.admin')

@section('title', 'Menu Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Menu Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.menus.edit', $menu) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Edit Menu
            </a>
            <a href="{{ route('admin.menus.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Back to Menus
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                @if($menu->icon)
                    <div class="flex-shrink-0 h-12 w-12 mr-4">
                        <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @switch($menu->icon)
                                    @case('home')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        @break
                                    @case('user')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        @break
                                    @case('briefcase')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        @break
                                    @default
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                @endswitch
                            </svg>
                        </div>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $menu->title }}</h2>
                    <p class="text-sm text-gray-500">{{ $menu->slug }}</p>
                    @if($menu->description)
                        <p class="text-sm text-gray-600 mt-1">{{ $menu->description }}</p>
                    @endif
                </div>
                <div class="ml-auto flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $menu->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $menu->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    @if($menu->is_system)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            System
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="px-6 py-4">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Sort Order</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $menu->sort_order }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Opens in New Tab</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $menu->opens_in_new_tab ? 'Yes' : 'No' }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Destination Type</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @if($menu->route_name)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Route
                            </span>
                            <span class="ml-2 text-gray-600">{{ $menu->route_name }}</span>
                        @elseif($menu->url)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                URL
                            </span>
                            <span class="ml-2 text-gray-600">{{ $menu->url }}</span>
                        @elseif($menu->page)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Page
                            </span>
                            <span class="ml-2 text-gray-600">{{ $menu->page->title }}</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                None
                            </span>
                        @endif
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Final URL</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @php
                            try {
                                $finalUrl = $menu->url;
                                echo $finalUrl !== '#' ? $finalUrl : 'No destination set';
                            } catch (Exception $e) {
                                echo 'Invalid route';
                            }
                        @endphp
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $menu->created_at->format('M j, Y g:i A') }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $menu->updated_at->format('M j, Y g:i A') }}</dd>
                </div>
            </dl>
        </div>

        @if($menu->page)
            <div class="border-t border-gray-200">
                <div class="px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Associated Page</h3>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Page Title</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $menu->page->title }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Page Slug</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $menu->page->slug }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Template</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($menu->page->template) }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Published</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $menu->page->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $menu->page->is_published ? 'Yes' : 'No' }}
                                    </span>
                                </dd>
                            </div>

                            @if($menu->page->excerpt)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Excerpt</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $menu->page->excerpt }}</dd>
                                </div>
                            @endif

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Content Preview</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <div class="bg-white border rounded p-3 max-h-32 overflow-y-auto">
                                        {{ Str::limit(strip_tags($menu->page->content), 200) }}
                                    </div>
                                </dd>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('pages.show', $menu->page->slug) }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium"
                               target="_blank">
                                View Page →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection