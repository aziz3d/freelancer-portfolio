@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    @include('partials.hero')

    @if(!$featuredWorkSection || ($featuredWorkSection->meta['is_visible'] ?? true))
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold font-display text-gray-900 mb-4">
                        {{ $featuredWorkSection->title ?? 'Featured Work' }}
                    </h2>
                    <p class="text-lg text-gray-600">
                        {{ $featuredWorkSection->content ?? 'A showcase of my latest projects and creative endeavors' }}
                    </p>
                </div>
            
            @if($featuredProjects->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($featuredProjects as $project)
                        <x-project-card :project="$project" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-500 mb-4">
                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No Featured Projects Yet</h3>
                    <p class="text-gray-500">Featured projects will appear here once they're added.</p>
                </div>
            @endif
            
            <div class="text-center mt-12">
                <a href="{{ route('projects.index') }}" 
                   class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                    View All Projects
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    @if((!$servicesSection || ($servicesSection->meta['is_visible'] ?? true)) && $featuredServices->count() > 0)
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold font-display text-gray-900 mb-4">
                        {{ $servicesSection->title ?? 'Services I Offer' }}
                    </h2>
                    <p class="text-lg text-gray-600">
                        {{ $servicesSection->content ?? 'Professional services tailored to bring your ideas to life' }}
                    </p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($featuredServices as $service)
                        <x-service-card :service="$service" />
                    @endforeach
                </div>
                
                <div class="text-center mt-12">
                    <a href="{{ route('services') }}" 
                       class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                        View All Services
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    @if((!$latestArticlesSection || ($latestArticlesSection->meta['is_visible'] ?? true)) && $recentBlogs->count() > 0)
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold font-display text-gray-900 mb-4">
                        {{ $latestArticlesSection->title ?? 'Latest Articles' }}
                    </h2>
                    <p class="text-lg text-gray-600">
                        {{ $latestArticlesSection->content ?? 'Insights, tutorials, and thoughts on development and design' }}
                    </p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($recentBlogs as $blog)
                        <x-blog-card :blog="$blog" />
                    @endforeach
                </div>
                
                <div class="text-center mt-12">
                    <a href="{{ route('blog.index') }}" 
                       class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                        View All Articles
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    @if((!$testimonialsSection || ($testimonialsSection->meta['is_visible'] ?? true)) && $featuredTestimonials->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold font-display text-gray-900 mb-4">
                        {{ $testimonialsSection->title ?? 'What Clients Say' }}
                    </h2>
                    <p class="text-lg text-gray-600">
                        {{ $testimonialsSection->content ?? 'Testimonials from satisfied clients and colleagues' }}
                    </p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($featuredTestimonials as $testimonial)
                        <x-testimonial-card :testimonial="$testimonial" />
                    @endforeach
                </div>
                
                <div class="text-center mt-12">
                    <a href="{{ route('testimonials') }}" 
                       class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                        View All Testimonials
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>

      @include('partials.stats')
        </section>
    @endif
</div>
@endsection