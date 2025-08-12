@extends('layouts.app')

@section('title', 'Services - ' . ($siteBranding['title'] ?? 'Aziz Khan'))
@section('meta_description', 'Professional services offered by ' . ($siteBranding['title'] ?? 'Aziz Khan') . ' including Web Development, 3D Modeling, UI/UX Design, Retopology, Rigging, and Rendering.')

@section('content')
<x-page-header 
    title="{{ $pageTitle['title'] ?? 'Professional Services' }}" 
    description="{{ $pageTitle['content'] ?? 'Comprehensive solutions for your digital and creative needs. From web development to 3D artistry, I deliver high-quality work that brings your vision to life.' }}"
    subtitle="{{ $pageTitle['meta']['subtitle'] ?? null }}">

    @if($services->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <x-service-card :service="$service" />
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No services found</h3>
                <p class="mt-2 text-gray-500">
                    There are no published services available at the moment.
                </p>
            </div>
        </div>
    @endif

    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl p-12 text-center text-white mt-12">
        <h2 class="text-3xl font-bold mb-4">{{ $servicesCta['title'] }}</h2>
        <p class="text-xl mb-8 opacity-90">
            {{ $servicesCta['content'] }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ $servicesCta['meta']['primary_button_url'] }}" 
               class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200">
                {{ $servicesCta['meta']['primary_button_text'] }}
            </a>
            <a href="{{ $servicesCta['meta']['secondary_button_url'] }}" 
               class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition-colors duration-200">
                {{ $servicesCta['meta']['secondary_button_text'] }}
            </a>
        </div>
    </div>
</x-page-header>
@endsection