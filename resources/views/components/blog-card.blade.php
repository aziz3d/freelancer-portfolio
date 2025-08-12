@props(['blog'])

<article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg focus-within:shadow-lg transition-all duration-300 group">

    <div class="aspect-w-16 aspect-h-9 relative overflow-hidden">
        @if($blog->thumbnail)
            <img 
                src="{{ asset($blog->thumbnail) }}" 
                alt="{{ $blog->title }} article thumbnail"
                class="w-full h-48 sm:h-52 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                loading="lazy"
            >
        @else
            <div class="w-full h-48 sm:h-52 md:h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center group-hover:from-blue-600 group-hover:to-purple-700 transition-colors duration-300">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        @endif
    </div>


    <div class="p-4 sm:p-6">

        @if($blog->tags && count($blog->tags) > 0)
            <div class="flex flex-wrap gap-2 mb-3" role="list" aria-label="Article tags">
                @foreach(array_slice($blog->tags, 0, 3) as $tag)
                    <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" role="listitem">
                        {{ $tag }}
                    </span>
                @endforeach
                @if(count($blog->tags) > 3)
                    <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600" 
                          role="listitem"
                          title="{{ implode(', ', array_slice($blog->tags, 3)) }}">
                        +{{ count($blog->tags) - 3 }}
                    </span>
                @endif
            </div>
        @endif

        <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
            <a href="{{ route('blog.show', $blog) }}" 
               class="hover:text-blue-600 focus:text-blue-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md"
               aria-label="Read article: {{ $blog->title }}">
                {{ $blog->title }}
            </a>
        </h3>


        @if($blog->excerpt)
            <p class="text-gray-600 mb-4 line-clamp-3 text-sm sm:text-base leading-relaxed">
                {{ $blog->excerpt }}
            </p>
        @endif


        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs sm:text-sm text-gray-500 mb-4">
            <time datetime="{{ $blog->published_at->format('Y-m-d') }}" 
                  class="flex items-center">
                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ $blog->published_at->format('M j, Y') }}</span>
            </time>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read</span>
            </span>
        </div>


        <div class="mt-4">
            <a 
                href="{{ route('blog.show', $blog) }}" 
                class="inline-flex items-center text-blue-600 hover:text-blue-800 focus:text-blue-800 font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md text-sm sm:text-base touch-manipulation"
                aria-label="Read full article: {{ $blog->title }}"
            >
                <span>Read more</span>
                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</article>