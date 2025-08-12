@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('description', $page->meta_description ?: $page->excerpt)
@section('keywords', $page->meta_keywords ? implode(', ', $page->meta_keywords) : '')

@section('content')
<x-page-header 
    :title="$page->title" 
    :description="$page->excerpt ?: ''">

    <div class="bg-white rounded-lg shadow-soft p-8">
        <div class="prose prose-gray max-w-none">
            <div class="text-gray-700 leading-relaxed space-y-6">
                {!! nl2br(e($page->content)) !!}
            </div>
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('home') }}" 
           class="text-gray-500 hover:text-gray-700 font-light text-sm">
            ← Back to Home
        </a>
    </div>
</x-page-header>
@endsection