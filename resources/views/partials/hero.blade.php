
<section
    class="relative h-[600px] px-4 sm:px-6 lg:px-8 overflow-hidden bg-gradient-to-br from-primary-50 via-white to-secondary-50 flex items-center"
    role="banner" aria-label="Hero section">

    @include('partials.hero-animations')

    <div class="max-w-7xl mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="text-left">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold font-display mb-4 sm:mb-6 leading-tight"
                    @if (isset($hero['meta']['title_color'])) style="color: {{ $hero['meta']['title_color'] }};"
                    @else
                        style="color: #111827;" @endif>
                    @if (isset($hero['title']))
                        {!! $hero['title'] !!}
                    @else
                        Hi, I'm <span class="text-primary-600">Aziz Khan</span>
                    @endif
                </h1>

                @if (isset($hero['meta']['subtitle']))
                    <p class="text-lg sm:text-xl md:text-2xl mb-6 sm:mb-8 leading-relaxed"
                        @if (isset($hero['meta']['subtitle_color'])) style="color: {{ $hero['meta']['subtitle_color'] }};"
                       @else
                           style="color: #4B5563;" @endif>
                        {{ $hero['meta']['subtitle'] }}
                    </p>
                @else
                    <p class="text-lg sm:text-xl md:text-2xl mb-6 sm:mb-8 leading-relaxed"
                        @if (isset($hero['meta']['subtitle_color'])) style="color: {{ $hero['meta']['subtitle_color'] }};"
                       @else
                           style="color: #4B5563;" @endif>
                        2D/3D Artist & Web Developer
                    </p>
                @endif

                @if (isset($hero['content']))
                    <p class="text-base sm:text-lg mb-8 sm:mb-12 max-w-xl leading-relaxed"
                        @if (isset($hero['meta']['description_color'])) style="color: {{ $hero['meta']['description_color'] }};"
                       @else
                           style="color: #6B7280;" @endif>
                        {{ $hero['content'] }}
                    </p>
                @else
                    <p class="text-base sm:text-lg mb-8 sm:mb-12 max-w-xl leading-relaxed"
                        @if (isset($hero['meta']['description_color'])) style="color: {{ $hero['meta']['description_color'] }};"
                       @else
                           style="color: #6B7280;" @endif>
                        I create digital experiences that blend creativity with functionality, specializing in Laravel
                        development, 3D modeling, and UI/UX design.
                    </p>
                @endif

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <a href="{{ $hero['meta']['cta_url'] ?? route('projects.index') }}"
                        class="inline-flex items-center justify-center bg-primary-600 hover:bg-primary-700 focus:bg-primary-700 text-white px-6 sm:px-8 py-3 rounded-lg font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 touch-manipulation hover:transform hover:scale-105"
                        aria-label="View my portfolio projects">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        {{ $hero['meta']['cta_text'] ?? 'View Projects' }}
                    </a>
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center justify-center border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:!text-white focus:bg-primary-600 focus:!text-white px-6 sm:px-8 py-3 rounded-lg font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 touch-manipulation hover:transform hover:scale-105"
                        aria-label="Contact me for project inquiries">
                        <svg class="w-5 h-5 mr-2 transition-colors duration-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Need Help?
                    </a>
                </div>
            </div>

            <div class="flex justify-center lg:justify-end">
                <div class="relative">

                    <div
                        class="absolute -inset-4 bg-gradient-to-r from-primary-200 to-secondary-200 rounded-full opacity-20 animate-pulse-slow blur-lg">
                    </div>
                    <div
                        class="absolute -inset-2 bg-gradient-to-r from-primary-300 to-secondary-300 rounded-full opacity-30 animate-spin-slow">
                    </div>

                    <div class="relative w-64 h-64 sm:w-80 sm:h-80 lg:w-96 lg:h-96">
                        <div
                            class="w-full h-full rounded-full border-4 border-white shadow-2xl overflow-hidden bg-gradient-to-br from-primary-50 to-secondary-50 relative">
                            @if (isset($hero['meta']['profile_photo']) && !empty($hero['meta']['profile_photo']))
                                <img src="{{ $hero['meta']['profile_photo'] }}"
                                    alt="{{ $siteBranding['title'] ?? 'Profile Photo' }}"
                                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-secondary-100">
                                    <div class="text-center">
                                        <div
                                            class="w-24 h-24 mx-auto mb-4 bg-primary-200 rounded-full flex items-center justify-center">
                                            <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <p class="text-primary-600 font-medium">Add Your Photo</p>
                                        <p class="text-sm text-primary-500 mt-1">Upload in Admin Panel</p>
                                    </div>
                                </div>
                            @endif


                            <div
                                class="absolute -top-2 -right-2 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center animate-bounce-slow">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                            </div>
                            <div
                                class="absolute -bottom-2 -left-2 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center animate-bounce-delayed">
                                <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                                </svg>
                            </div>
                            <div
                                class="absolute top-1/2 -right-4 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center animate-pulse-medium">
                                <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
