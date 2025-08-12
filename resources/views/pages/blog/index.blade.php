@extends('layouts.app')

@section('title', 'Blog - ' . ($siteBranding['title'] ?? 'Aziz Khan'))
@section('meta_description', 'Read insights, tutorials, and thoughts on web development, 3D modeling, and design by ' . ($siteBranding['title'] ?? 'Aziz Khan') . '.')

@section('content')
<x-page-header 
    title="{{ $pageTitle['title'] ?? 'Blog' }}" 
    description="{{ $pageTitle['content'] ?? 'Insights, tutorials, and thoughts on web development, 3D modeling, and design.' }}"
    subtitle="{{ $pageTitle['meta']['subtitle'] ?? null }}">

    @if($blogs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($blogs as $blog)
                <x-blog-card :blog="$blog" />
            @endforeach
        </div>

        <div class="flex justify-center">
            {{ $blogs->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No blog posts found</h3>
                <p class="mt-2 text-gray-500">There are no published blog posts available at the moment.</p>
            </div>
        </div>
    @endif
</x-page-header>
@endsection