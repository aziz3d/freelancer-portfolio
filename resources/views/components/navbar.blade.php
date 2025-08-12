<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100" role="navigation" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}"
                   class="flex items-center focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 rounded-md"
                   aria-label="{{ $siteBranding['title'] ?? 'Aziz Khan' }} - Home">
                    @if(isset($siteBranding['meta']['logo']) && $siteBranding['meta']['logo'])
                        <img src="{{ $siteBranding['meta']['logo'] }}"
                             alt="{{ $siteBranding['meta']['logo_alt'] ?? 'Site Logo' }}"
                             class="h-8 sm:h-10 w-auto object-contain">
                    @else
                        <span class="text-xl sm:text-2xl font-bold font-display text-primary-600">{{ $siteBranding['title'] ?? 'Aziz Khan' }}</span>
                    @endif
                </a>
            </div>

            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4 lg:space-x-8">
                    @php
                        // Force fresh query to avoid caching issues
                        $menus = \App\Models\Menu::where('is_active', true)->orderBy('sort_order')->orderBy('title')->get();
                    @endphp
                    @foreach($menus as $menu)
                        @php
                            $url = $menu->url;
                            $isActive = false;
                            
                            // Check if current route matches menu
                            if ($menu->route_name && request()->routeIs($menu->route_name)) {
                                $isActive = true;
                            } elseif ($menu->route_name && str_contains($menu->route_name, '.')) {
                                // Check for route pattern matching (e.g., blog.* for blog.index, blog.show)
                                $routePrefix = explode('.', $menu->route_name)[0];
                                if (request()->routeIs($routePrefix . '.*')) {
                                    $isActive = true;
                                }
                            } elseif ($menu->page && request()->is('page/' . $menu->page->slug)) {
                                $isActive = true;
                            }
                            
                            // Additional check for URL path matching if route matching fails
                            if (!$isActive && $menu->url) {
                                $currentPath = request()->path();
                                $menuPath = parse_url($menu->url, PHP_URL_PATH);
                                if ($menuPath && $currentPath === ltrim($menuPath, '/')) {
                                    $isActive = true;
                                }
                            }
                            
                            // Special handling for common routes that might not match
                            if (!$isActive) {
                                $currentRouteName = request()->route() ? request()->route()->getName() : '';
                                
                                // Handle blog routes specifically
                                if (($menu->route_name === 'blog.index' || $menu->title === 'Blog') && 
                                    (str_starts_with($currentRouteName, 'blog.') || request()->is('blog*'))) {
                                    $isActive = true;
                                }
                                
                                // Handle projects routes specifically  
                                if (($menu->route_name === 'projects.index' || $menu->title === 'Projects') && 
                                    (str_starts_with($currentRouteName, 'projects.') || request()->is('projects*'))) {
                                    $isActive = true;
                                }
                                
                                // Handle services routes specifically
                                if (($menu->route_name === 'services' || $menu->title === 'Services') && 
                                    ($currentRouteName === 'services' || request()->is('services*'))) {
                                    $isActive = true;
                                }
                                
                                // Handle contact routes specifically
                                if (($menu->route_name === 'contact' || $menu->title === 'Contact') && 
                                    ($currentRouteName === 'contact' || request()->is('contact*'))) {
                                    $isActive = true;
                                }
                                
                                // Handle testimonials routes specifically
                                if (($menu->route_name === 'testimonials' || $menu->title === 'Testimonials') && 
                                    ($currentRouteName === 'testimonials' || request()->is('testimonials*'))) {
                                    $isActive = true;
                                }
                                
                                // Handle about routes specifically
                                if (($menu->route_name === 'about' || $menu->title === 'About') && 
                                    ($currentRouteName === 'about' || request()->is('about*'))) {
                                    $isActive = true;
                                }
                            }
                        @endphp
                        <a href="{{ $url }}" 
                           class="nav-link {{ $isActive ? 'text-primary-600 border-b-2 border-primary-600' : 'text-gray-700 hover:text-primary-600 focus:text-primary-600' }} px-3 py-2 text-sm font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 rounded-md"
                           {{ $isActive ? 'aria-current="page"' : '' }}
                           {{ $menu->opens_in_new_tab ? 'target="_blank" rel="noopener noreferrer"' : '' }}>
                            {{ $menu->title }}
                        </a>
                    @endforeach
                </div>
            </div>

           
            <div class="md:hidden">
                <button type="button" 
                        class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-primary-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-colors duration-200"
                        aria-controls="mobile-menu" 
                        aria-expanded="false"
                        aria-label="Toggle main menu">
                    <span class="sr-only">Open main menu</span>
                  
                    <svg class="hamburger-icon block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                 
                    <svg class="close-icon hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

   
    <div class="mobile-menu hidden md:hidden" id="mobile-menu" role="menu" aria-labelledby="mobile-menu-button">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-100 shadow-lg">
            @foreach($menus as $menu)
                @php
                    $url = $menu->url;
                    $isActive = false;
                    
                    // Check if current route matches menu
                    if ($menu->route_name && request()->routeIs($menu->route_name)) {
                        $isActive = true;
                    } elseif ($menu->route_name && str_contains($menu->route_name, '.')) {
                        // Check for route pattern matching (e.g., blog.* for blog.index, blog.show)
                        $routePrefix = explode('.', $menu->route_name)[0];
                        if (request()->routeIs($routePrefix . '.*')) {
                            $isActive = true;
                        }
                    } elseif ($menu->page && request()->is('page/' . $menu->page->slug)) {
                        $isActive = true;
                    }
                    
                    // Additional check for URL path matching if route matching fails
                    if (!$isActive && $menu->url) {
                        $currentPath = request()->path();
                        $menuPath = parse_url($menu->url, PHP_URL_PATH);
                        if ($menuPath && $currentPath === ltrim($menuPath, '/')) {
                            $isActive = true;
                        }
                    }
                    
                    // Special handling for common routes that might not match
                    if (!$isActive) {
                        $currentRouteName = request()->route() ? request()->route()->getName() : '';
                        
                        // Handle blog routes specifically
                        if (($menu->route_name === 'blog.index' || $menu->title === 'Blog') && 
                            (str_starts_with($currentRouteName, 'blog.') || request()->is('blog*'))) {
                            $isActive = true;
                        }
                        
                        // Handle projects routes specifically  
                        if (($menu->route_name === 'projects.index' || $menu->title === 'Projects') && 
                            (str_starts_with($currentRouteName, 'projects.') || request()->is('projects*'))) {
                            $isActive = true;
                        }
                        
                        // Handle services routes specifically
                        if (($menu->route_name === 'services' || $menu->title === 'Services') && 
                            ($currentRouteName === 'services' || request()->is('services*'))) {
                            $isActive = true;
                        }
                        
                        // Handle contact routes specifically
                        if (($menu->route_name === 'contact' || $menu->title === 'Contact') && 
                            ($currentRouteName === 'contact' || request()->is('contact*'))) {
                            $isActive = true;
                        }
                        
                        // Handle testimonials routes specifically
                        if (($menu->route_name === 'testimonials' || $menu->title === 'Testimonials') && 
                            ($currentRouteName === 'testimonials' || request()->is('testimonials*'))) {
                            $isActive = true;
                        }
                        
                        // Handle about routes specifically
                        if (($menu->route_name === 'about' || $menu->title === 'About') && 
                            ($currentRouteName === 'about' || request()->is('about*'))) {
                            $isActive = true;
                        }
                    }
                    
                    // Get icon SVG
                    $iconSvg = match($menu->icon) {
                        'home' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                        'user' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                        'briefcase' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>',
                        'document-text' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                        'cog' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
                        'chat-bubble-left-right' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>',
                        'envelope' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                        default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>',
                    };
                @endphp
                <a href="{{ $url }}" 
                   class="mobile-nav-link {{ $isActive ? 'bg-primary-50 text-primary-600 border-l-4 border-primary-600' : 'text-gray-700 hover:bg-gray-50 hover:text-primary-600 focus:bg-gray-50 focus:text-primary-600' }} block px-4 py-3 text-base font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 rounded-r-md touch-manipulation"
                   role="menuitem"
                   {{ $isActive ? 'aria-current="page"' : '' }}
                   {{ $menu->opens_in_new_tab ? 'target="_blank" rel="noopener noreferrer"' : '' }}>
                    <span class="flex items-center">
                        @if($menu->icon)
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                {!! $iconSvg !!}
                            </svg>
                        @endif
                        {{ $menu->title }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</nav>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    const hamburgerIcon = document.querySelector('.hamburger-icon');
    const closeIcon = document.querySelector('.close-icon');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

    if (mobileMenuButton && mobileMenu) {
      
        function toggleMobileMenu() {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            const newState = !isExpanded;
            
           
            if (newState) {
                mobileMenu.classList.remove('hidden');
                mobileMenu.offsetHeight;
                mobileMenu.classList.add('animate-fade-in');
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('animate-fade-in');
            }
            
            
            hamburgerIcon.classList.toggle('hidden', newState);
            closeIcon.classList.toggle('hidden', !newState);
            
            
            mobileMenuButton.setAttribute('aria-expanded', newState);
            mobileMenuButton.setAttribute('aria-label', newState ? 'Close main menu' : 'Open main menu');
            
           
            if (newState && mobileNavLinks.length > 0) {
               
                setTimeout(() => mobileNavLinks[0].focus(), 100);
            } else if (!newState) {
                
                mobileMenuButton.focus();
            }
        }

     
        function closeMobileMenu() {
            if (mobileMenuButton.getAttribute('aria-expanded') === 'true') {
                toggleMobileMenu();
            }
        }

       
        mobileMenuButton.addEventListener('click', toggleMobileMenu);

      
        mobileMenuButton.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleMobileMenu();
            }
        });

       
        mobileMenu.addEventListener('keydown', function(e) {
            const focusableElements = Array.from(mobileNavLinks);
            const currentIndex = focusableElements.indexOf(document.activeElement);

            switch (e.key) {
                case 'Escape':
                    e.preventDefault();
                    closeMobileMenu();
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    const nextIndex = (currentIndex + 1) % focusableElements.length;
                    focusableElements[nextIndex].focus();
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    const prevIndex = currentIndex <= 0 ? focusableElements.length - 1 : currentIndex - 1;
                    focusableElements[prevIndex].focus();
                    break;
                case 'Home':
                    e.preventDefault();
                    focusableElements[0].focus();
                    break;
                case 'End':
                    e.preventDefault();
                    focusableElements[focusableElements.length - 1].focus();
                    break;
            }
        });

        
        document.addEventListener('click', function(event) {
            if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                closeMobileMenu();
            }
        });

        
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth >= 768) {
                    closeMobileMenu();
                }
            }, 100);
        });

       
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
               
                setTimeout(closeMobileMenu, 100);
            });
        });

       
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab' && mobileMenuButton.getAttribute('aria-expanded') === 'true') {
                const focusableElements = [mobileMenuButton, ...mobileNavLinks];
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];

                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            }
        });
    }

   
    function announcePageChange() {
        const announcements = document.getElementById('sr-announcements');
        if (announcements) {
            const currentPage = document.querySelector('nav a[aria-current="page"]');
            if (currentPage) {
                announcements.textContent = `Navigated to ${currentPage.textContent.trim()} page`;
            }
        }
    }

   
    announcePageChange();
});
</script>
@endpush