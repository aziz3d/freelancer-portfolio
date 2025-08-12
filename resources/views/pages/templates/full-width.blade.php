@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('description', $page->meta_description ?: $page->excerpt)
@section('keywords', $page->meta_keywords ? implode(', ', $page->meta_keywords) : '')

@section('content')
<x-page-header 
    :title="$page->title" 
    :description="$page->excerpt ?: ''">

    <div class="bg-white rounded-lg shadow-soft p-8">
        <div class="prose prose-lg max-w-none">
            {!! nl2br(e($page->content)) !!}
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center text-primary-600 hover:text-primary-800 font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Home
        </a>
    </div>
</x-page-header>
@endsection