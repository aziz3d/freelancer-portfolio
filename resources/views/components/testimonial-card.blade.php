@props(['testimonial'])

<article class="bg-white rounded-lg shadow-soft p-4 sm:p-6 hover:shadow-medium focus-within:shadow-medium transition-all duration-300 group">
    <div class="mb-4" aria-hidden="true">
        <svg class="w-6 sm:w-8 h-6 sm:h-8 text-primary-200" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
        </svg>
    </div>
    
    <blockquote class="text-gray-700 mb-6 line-clamp-4 text-sm sm:text-base leading-relaxed">
        <span class="sr-only">Quote from {{ $testimonial->name }}:</span>
        "{{ $testimonial->content }}"
    </blockquote>
    

    <div class="flex items-center">
        <div class="w-10 sm:w-12 h-10 sm:h-12 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center mr-3 sm:mr-4 overflow-hidden flex-shrink-0">
            @if($testimonial->avatar)
                <img src="{{ asset('storage/' . $testimonial->avatar) }}" 
                     alt="Profile photo of {{ $testimonial->name }}" 
                     class="w-full h-full object-cover"
                     loading="lazy">
            @else
                <svg class="w-5 sm:w-6 h-5 sm:h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            @endif
        </div>
        
    
        <div class="min-w-0 flex-1">
            <div class="font-semibold text-gray-900 text-sm sm:text-base truncate">{{ $testimonial->name }}</div>
            <div class="text-xs sm:text-sm text-gray-600 truncate">
                {{ $testimonial->role }}
                @if($testimonial->company)
                    <span class="hidden sm:inline">at {{ $testimonial->company }}</span>
                    <span class="sm:hidden">@ {{ $testimonial->company }}</span>
                @endif
            </div>
        </div>
    </div>
    

    @if($testimonial->rating)
        <div class="flex items-center mt-3" role="img" aria-label="{{ $testimonial->rating }} out of 5 stars">
            <span class="sr-only">Rating: {{ $testimonial->rating }} out of 5 stars</span>
            @for($i = 1; $i <= 5; $i++)
                <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                     fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            @endfor
        </div>
    @endif
</article>