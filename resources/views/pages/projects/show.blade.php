@extends('layouts.app')

@section('title', $project->title . ' - Aziz Khan')
@section('meta_description', $project->description)

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('projects.index') }}" class="ml-1 text-gray-500 hover:text-gray-700 md:ml-2">Projects</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-700 md:ml-2">{{ $project->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>


        <div class="bg-white rounded-lg shadow-soft overflow-hidden mb-8">
            <div class="h-64 md:h-96 bg-gradient-to-br from-primary-100 to-primary-200 relative overflow-hidden">
                @if($project->thumbnail)
                    <img src="{{ asset(str_contains($project->thumbnail, '/') ? $project->thumbnail : 'images/' . $project->thumbnail) }}" 
                         alt="{{ $project->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

    
            <div class="p-6 md:p-8">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    <div class="flex-1">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $project->title }}</h1>
                        <p class="text-lg text-gray-600 mb-6">{{ $project->description }}</p>

               
                        @if($project->technologies && count($project->technologies) > 0)
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Technologies Used</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($project->technologies as $tech)
                                        <span class="px-3 py-1 bg-primary-100 text-primary-700 text-sm rounded-full">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

        
                        @if($project->tags && count($project->tags) > 0)
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Tags</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($project->tags as $tag)
                                        <span class="px-3 py-1 bg-secondary-100 text-secondary-700 text-sm rounded-full">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

              
                    <div class="flex flex-col sm:flex-row lg:flex-col gap-3">
                        @if($project->project_url)
                            <a href="{{ $project->project_url }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                View Live Project
                            </a>
                        @endif

                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="inline-flex items-center justify-center px-6 py-3 bg-gray-800 text-white rounded-md hover:bg-gray-900 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                                View on GitHub
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

  
        @if($project->content)
            <div class="bg-white rounded-lg shadow-soft p-6 md:p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Project Details</h2>
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($project->content)) !!}
                </div>
            </div>
        @endif

   
        @if($project->images && count($project->images) > 0)
            <div class="bg-white rounded-lg shadow-soft p-6 md:p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Project Gallery</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($project->images as $image)
                        <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition-opacity duration-200"
                             onclick="openImageModal('{{ asset(str_contains($image, '/') ? $image : 'images/' . $image) }}', '{{ $project->title }}')">
                            <img src="{{ asset(str_contains($image, '/') ? $image : 'images/' . $image) }}" 
                                 alt="{{ $project->title }} - Gallery Image" 
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

     
        @if($relatedProjects->count() > 0)
            <div class="bg-white rounded-lg shadow-soft p-6 md:p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Projects</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedProjects as $relatedProject)
                        <x-project-card :project="$relatedProject" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" 
                class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
    </div>
</div>

@push('scripts')
<script>
function openImageModal(imageSrc, imageAlt) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    modalImage.src = imageSrc;
    modalImage.alt = imageAlt;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endpush
@endsection