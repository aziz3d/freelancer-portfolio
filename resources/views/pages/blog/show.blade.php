@extends('layouts.app')

@php
    $title = $blog->meta_title ?: $blog->title . ' - Aziz Khan';
    $description = $blog->meta_description ?: $blog->excerpt;
    $ogType = 'article';
    $ogUrl = route('blog.show', $blog);
    $ogImage = $blog->thumbnail ? asset($blog->thumbnail) : asset('images/og-default.jpg');
@endphp

@push('meta')
    <meta property="article:published_time" content="{{ $blog->published_at->toISOString() }}">
    <meta property="article:modified_time" content="{{ $blog->updated_at->toISOString() }}">
    @if($blog->tags)
        @foreach($blog->tags as $tag)
            <meta property="article:tag" content="{{ $tag }}">
        @endforeach
    @endif
@endpush

@section('content')
<div class="min-h-screen bg-white">
    <div class="bg-gray-50 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('blog.index') }}" class="ml-1 text-gray-500 hover:text-gray-700 md:ml-2">
                                Blog
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 truncate">{{ $blog->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <header class="mb-8">
                @if($blog->tags && count($blog->tags) > 0)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($blog->tags as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    {{ $blog->title }}
                </h1>
                @if($blog->excerpt)
                    <p class="text-xl text-gray-600 mb-6 leading-relaxed">
                        {{ $blog->excerpt }}
                    </p>
                @endif

                <div class="flex items-center text-gray-500 text-sm">
                    <time datetime="{{ $blog->published_at->format('Y-m-d') }}" class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $blog->published_at->format('F j, Y') }}
                    </time>
                    <span class="mx-3">•</span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read
                    </span>
                </div>
            </header>

            @if($blog->thumbnail)
                <div class="mb-8">
                    <img 
                        src="{{ asset($blog->thumbnail) }}" 
                        alt="{{ $blog->title }}"
                        class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg"
                    >
                </div>
            @endif
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="prose prose-lg max-w-none">
            <div style="display: none;">{{ $blog->content }}</div>
            {!! $blog->rendered_content !!}
        </div>
    </div>

    @if($previousBlog || $nextBlog)
        <div class="border-t border-gray-200 bg-gray-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @if($previousBlog)
                        <div class="text-left">
                            <p class="text-sm text-gray-500 mb-2">Previous Article</p>
                            <a href="{{ route('blog.show', $previousBlog) }}" class="group">
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                    {{ $previousBlog->title }}
                                </h3>
                                <p class="text-gray-600 mt-1 line-clamp-2">{{ $previousBlog->excerpt }}</p>
                            </a>
                        </div>
                    @endif

                    @if($nextBlog)
                        <div class="text-left md:text-right">
                            <p class="text-sm text-gray-500 mb-2">Next Article</p>
                            <a href="{{ route('blog.show', $nextBlog) }}" class="group">
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                    {{ $nextBlog->title }}
                                </h3>
                                <p class="text-gray-600 mt-1 line-clamp-2">{{ $nextBlog->excerpt }}</p>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if($relatedBlogs->count() > 0)
        <div class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Related Articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($relatedBlogs as $relatedBlog)
                        <x-blog-card :blog="$relatedBlog" />
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="bg-gray-50 border-t border-gray-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center">
            <a 
                href="{{ route('blog.index') }}" 
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Blog
            </a>
        </div>
    </div>
</div>
@endsection