@props(['project'])

<article class="bg-white rounded-lg shadow-soft overflow-hidden hover:shadow-medium focus-within:shadow-medium transition-all duration-300 group">
    <div class="h-48 sm:h-52 md:h-48 lg:h-52 bg-gradient-to-br from-primary-100 to-primary-200 relative overflow-hidden">
        @if($project->thumbnail)
            <x-optimized-image 
                :path="$project->thumbnail"
                :alt="$project->title . ' project thumbnail'"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                thumbnail="true"
            />
        @else
            <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center group-hover:from-primary-200 group-hover:to-primary-300 transition-colors duration-300">
                <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
    </div>
    

    <div class="p-4 sm:p-6">
        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
            {{ $project->title }}
        </h3>
        <p class="text-gray-600 mb-4 line-clamp-2 text-sm sm:text-base leading-relaxed">
            {{ $project->description }}
        </p>
        
    
        @if($project->technologies && count($project->technologies) > 0)
            <div class="flex flex-wrap gap-2 mb-4" role="list" aria-label="Technologies used">
                @foreach(array_slice($project->technologies, 0, 3) as $tech)
                    <span class="px-2 sm:px-3 py-1 bg-primary-100 text-primary-700 text-xs sm:text-sm rounded-full font-medium" role="listitem">
                        {{ $tech }}
                    </span>
                @endforeach
                @if(count($project->technologies) > 3)
                    <span class="px-2 sm:px-3 py-1 bg-gray-100 text-gray-600 text-xs sm:text-sm rounded-full font-medium" 
                          role="listitem"
                          title="{{ implode(', ', array_slice($project->technologies, 3)) }}">
                        +{{ count($project->technologies) - 3 }} more
                    </span>
                @endif
            </div>
        @endif
        
     
        <a href="{{ route('projects.show', $project->slug) }}" 
           class="inline-flex items-center text-primary-600 hover:text-primary-700 focus:text-primary-700 font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 rounded-md text-sm sm:text-base touch-manipulation"
           aria-label="View details for {{ $project->title }} project">
            <span>View Project</span>
            <svg class="ml-1 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</article>