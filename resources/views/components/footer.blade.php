<footer class="bg-gray-900 text-white" role="contentinfo" aria-label="Site footer">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-2">
                <div class="flex items-center mb-4">
                    <span class="text-xl sm:text-2xl font-bold font-display text-white">
                        @if(isset($footer['title']))
                            {{ $footer['title'] }}
                        @else
                            Aziz Khan
                        @endif
                    </span>
                </div>
                <p class="text-gray-300 mb-6 max-w-md text-sm sm:text-base leading-relaxed">
                    @if(isset($footer['content']))
                        {{ $footer['content'] }}
                    @else
                        2D/3D Artist & Web Developer passionate about creating digital experiences that blend creativity with functionality. Specializing in Laravel development, 3D modeling, and UI/UX design.
                    @endif
                </p>
                
      
                @if(isset($footer['meta']['social']['links']) && !empty(array_filter($footer['meta']['social']['links'])))
                    <div class="flex flex-wrap gap-4" role="list" aria-label="Social media links">
                        @if(!empty($footer['meta']['social']['links']['linkedin']))
                            <a href="{{ $footer['meta']['social']['links']['linkedin'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-gray-400 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md p-1"
                               aria-label="Visit LinkedIn profile (opens in new tab)"
                               role="listitem">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        @endif
                        
                        @if(!empty($footer['meta']['social']['links']['github']))
                            <a href="{{ $footer['meta']['social']['links']['github'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-gray-400 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md p-1"
                               aria-label="Visit GitHub profile (opens in new tab)"
                               role="listitem">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @endif
                        
                        @if(!empty($footer['meta']['social']['links']['twitter']))
                            <a href="{{ $footer['meta']['social']['links']['twitter'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-gray-400 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md p-1"
                               aria-label="Visit Twitter profile (opens in new tab)"
                               role="listitem">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                        @endif
                        
                        @if(!empty($footer['meta']['social']['links']['instagram']))
                            <a href="{{ $footer['meta']['social']['links']['instagram'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-gray-400 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md p-1"
                               aria-label="Visit Instagram profile (opens in new tab)"
                               role="listitem">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.017 0C8.396 0 7.929.01 6.71.048 5.493.085 4.73.204 4.058.388a5.918 5.918 0 0 0-2.134 1.39 5.918 5.918 0 0 0-1.39 2.134C.204 4.73.085 5.493.048 6.71.01 7.929 0 8.396 0 12.017s.01 4.088.048 5.307c.037 1.217.156 1.98.34 2.652a5.918 5.918 0 0 0 1.39 2.134 5.918 5.918 0 0 0 2.134 1.39c.672.184 1.435.303 2.652.34 1.219.038 1.686.048 5.307.048s4.088-.01 5.307-.048c1.217-.037 1.98-.156 2.652-.34a5.918 5.918 0 0 0 2.134-1.39 5.918 5.918 0 0 0 1.39-2.134c.184-.672.303-1.435.34-2.652.038-1.219.048-1.686.048-5.307s-.01-4.088-.048-5.307c-.037-1.217-.156-1.98-.34-2.652a5.918 5.918 0 0 0-1.39-2.134A5.918 5.918 0 0 0 19.976.388C19.304.204 18.541.085 17.324.048 16.105.01 15.638 0 12.017 0zm0 2.162c3.204 0 3.584.012 4.85.07 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.06 1.265.072 1.646.072 4.85s-.012 3.584-.072 4.85c-.053 1.17-.249 1.805-.413 2.227a3.81 3.81 0 0 1-.896 1.382 3.744 3.744 0 0 1-1.382.896c-.422.164-1.057.36-2.227.413-1.266.06-1.646.072-4.85.072s-3.584-.012-4.85-.072c-1.17-.053-1.805-.249-2.227-.413a3.81 3.81 0 0 1-1.382-.896 3.744 3.744 0 0 1-.896-1.382c-.164-.422-.36-1.057-.413-2.227-.06-1.265-.072-1.646-.072-4.85s.012-3.584.072-4.85c.053-1.17.249-1.805.413-2.227.217-.562.477-.96.896-1.382a3.81 3.81 0 0 1 1.382-.896c.422-.164 1.057-.36 2.227-.413 1.266-.06 1.646-.072 4.85-.072z"/>
                                    <path d="M12.017 15.33a3.312 3.312 0 1 1 0-6.624 3.312 3.312 0 0 1 0 6.624zM12.017 7.052a4.963 4.963 0 1 0 0 9.926 4.963 4.963 0 0 0 0-9.926zM18.286 6.776a1.16 1.16 0 1 1-2.32 0 1.16 1.16 0 0 1 2.32 0z"/>
                                </svg>
                            </a>
                        @endif
                        
                        @if(!empty($footer['meta']['social']['links']['facebook']))
                            <a href="{{ $footer['meta']['social']['links']['facebook'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-gray-400 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md p-1"
                               aria-label="Visit Facebook profile (opens in new tab)"
                               role="listitem">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @endif
                        
                        @if(!empty($footer['meta']['social']['links']['youtube']))
                            <a href="{{ $footer['meta']['social']['links']['youtube'] }}" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="text-gray-400 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md p-1"
                               aria-label="Visit YouTube channel (opens in new tab)"
                               role="listitem">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @endif
                        
                  
                        <a href="mailto:{{ $footer['meta']['email'] ?? 'contact@azizkhan.dev' }}" 
                           class="text-gray-400 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md p-1"
                           aria-label="Send email to {{ $footer['meta']['email'] ?? 'contact@azizkhan.dev' }}"
                           role="listitem">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                    </div>
                @else
       
                    <div class="flex flex-wrap gap-4" role="list" aria-label="Social media links">
                        <a href="mailto:{{ $footer['meta']['email'] ?? 'contact@azizkhan.dev' }}" 
                           class="text-gray-400 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md p-1"
                           aria-label="Send email to {{ $footer['meta']['email'] ?? 'contact@azizkhan.dev' }}"
                           role="listitem">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
            
        
            <div>
                <h3 class="text-base sm:text-lg font-semibold mb-4 text-white">
                    {{ $footer['meta']['quick_links']['title'] ?? 'Quick Links' }}
                </h3>
                <nav aria-label="Footer navigation">
                    <ul class="space-y-2">
                        @if(isset($footer['meta']['quick_links']['links']))
                            @foreach($footer['meta']['quick_links']['links'] as $key => $url)
                                @if(!empty($url))
                                    <li>
                                        <a href="{{ $url }}" 
                                           class="text-gray-300 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md text-sm sm:text-base">
                                            {{ ucfirst($key) }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @else
                           
                            <li>
                                <a href="{{ route('home') }}" 
                                   class="text-gray-300 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md text-sm sm:text-base">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('about') }}" 
                                   class="text-gray-300 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md text-sm sm:text-base">
                                    About
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('projects.index') }}" 
                                   class="text-gray-300 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md text-sm sm:text-base">
                                    Projects
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('contact') }}" 
                                   class="text-gray-300 hover:text-white focus:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-900 rounded-md text-sm sm:text-base">
                                    Contact
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
            
         
            <div>
                <h3 class="text-base sm:text-lg font-semibold mb-4 text-white">
                    {{ $footer['meta']['services']['title'] ?? 'Services' }}
                </h3>
                <ul class="space-y-2" role="list" aria-label="Services offered">
                    @if(isset($footer['meta']['services']['list']) && is_array($footer['meta']['services']['list']))
                        @foreach($footer['meta']['services']['list'] as $service)
                            @if(!empty($service))
                                <li class="text-gray-300 text-sm sm:text-base" role="listitem">{{ $service }}</li>
                            @endif
                        @endforeach
                    @else
                        <li class="text-gray-300 text-sm sm:text-base" role="listitem">Web Development</li>
                        <li class="text-gray-300 text-sm sm:text-base" role="listitem">3D Modeling</li>
                        <li class="text-gray-300 text-sm sm:text-base" role="listitem">UI/UX Design</li>
                        <li class="text-gray-300 text-sm sm:text-base" role="listitem">Graphic Design</li>
                    @endif
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-6 mb-4 md:mb-0">
                    <div class="flex items-center text-gray-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:{{ $footer['meta']['email'] ?? 'contact@azizkhan.dev' }}" class="hover:text-white transition-colors duration-200">
                            {{ $footer['meta']['email'] ?? 'contact@azizkhan.dev' }}
                        </a>
                    </div>
                    
                    <div class="flex items-center text-gray-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>
                            {{ $footer['meta']['remote']['title'] ?? 'Available Worldwide (Remote)' }}
                            @if(isset($footer['meta']['remote']['timezone']))
                                - {{ $footer['meta']['remote']['timezone'] }}
                            @endif
                        </span>
                    </div>
                </div>
                
              
                <div class="text-gray-400 text-sm">
                    <p>
                        @if(isset($footer['meta']['copyright']))
                            {{ $footer['meta']['copyright'] }}
                        @else
                            &copy; {{ date('Y') }} Aziz Khan. All rights reserved.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    
  
    <button id="back-to-top" 
            class="fixed bottom-4 right-4 sm:bottom-8 sm:right-8 bg-primary-600 hover:bg-primary-700 focus:bg-primary-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 invisible focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 z-40 touch-manipulation"
            aria-label="Scroll back to top of page"
            title="Back to top">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>
</footer>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('back-to-top');
    
    if (backToTopButton) {
        let isScrolling = false;
        
       
        function handleScroll() {
            if (!isScrolling) {
                window.requestAnimationFrame(function() {
                    const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                    const shouldShow = scrollPosition > 300;
                    
                    if (shouldShow) {
                        backToTopButton.classList.remove('opacity-0', 'invisible');
                        backToTopButton.classList.add('opacity-100', 'visible');
                        backToTopButton.setAttribute('tabindex', '0');
                    } else {
                        backToTopButton.classList.add('opacity-0', 'invisible');
                        backToTopButton.classList.remove('opacity-100', 'visible');
                        backToTopButton.setAttribute('tabindex', '-1');
                    }
                    
                    isScrolling = false;
                });
                isScrolling = true;
            }
        }
        
        
        window.addEventListener('scroll', handleScroll, { passive: true });
        
     
        function scrollToTop() {
           
            const announcements = document.getElementById('sr-announcements');
            if (announcements) {
                announcements.textContent = 'Scrolling to top of page';
            }
            
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
           
            setTimeout(function() {
                const skipLink = document.querySelector('a[href="#main-content"]');
                if (skipLink) {
                    skipLink.focus();
                }
            }, 500);
        }
        
        backToTopButton.addEventListener('click', scrollToTop);
        
      
        backToTopButton.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                scrollToTop();
            }
        });
        
        backToTopButton.setAttribute('tabindex', '-1');
    }
});
</script>
@endpush