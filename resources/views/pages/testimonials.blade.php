@extends('layouts.app')

@section('title', 'Testimonials - ' . ($siteBranding['title'] ?? 'Aziz Khan'))
@section('meta_description', 'Read what clients and colleagues say about working with ' . ($siteBranding['title'] ?? 'Aziz Khan') . '. Professional testimonials and reviews from satisfied customers.')

@section('content')
<x-page-header 
    title="Client Testimonials" 
    description="Don't just take my word for it. Here's what clients and colleagues have to say about working with me and the quality of work I deliver.">

    @if($testimonials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
                <x-testimonial-card :testimonial="$testimonial" />
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No testimonials found</h3>
                <p class="mt-2 text-gray-500">
                    There are no published testimonials available at the moment.
                </p>
            </div>
        </div>
    @endif
</x-page-header>
@endsection