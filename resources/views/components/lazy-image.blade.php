@props([
    'src' => '',
    'webp' => null,
    'alt' => '',
    'class' => '',
    'loading' => 'lazy',
    'width' => null,
    'height' => null,
    'placeholder' => 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjNmNGY2Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgc2Fucy1zZXJpZiIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzlmYTZiNyIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkxvYWRpbmcuLi48L3RleHQ+PC9zdmc+'
])

<picture class="lazy-image-container {{ $class }}">
    @if($webp)
        <source srcset="{{ $webp }}" type="image/webp">
    @endif
    
    <img 
        src="{{ $placeholder }}"
        data-src="{{ $src }}"
        alt="{{ $alt }}"
        loading="{{ $loading }}"
        class="lazy-image transition-opacity duration-300 opacity-0"
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
        {{ $attributes->except(['src', 'webp', 'alt', 'class', 'loading', 'width', 'height', 'placeholder']) }}
    >
</picture>

@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.getAttribute('data-src');
                        
                        if (src) {
                            img.src = src;
                            img.classList.add('opacity-100');
                            img.classList.remove('opacity-0');
                            
                            img.onload = function() {
                                img.classList.add('loaded');
                            };
                            
                            img.onerror = function() {
                                img.classList.add('error');
                           
                                console.warn('Failed to load image:', src);
                            };
                            
                            observer.unobserve(img);
                        }
                    }
                });
            }, {
                rootMargin: '50px 0px',
                threshold: 0.01
            });

        
            document.querySelectorAll('.lazy-image').forEach(img => {
                imageObserver.observe(img);
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .lazy-image-container {
            position: relative;
            overflow: hidden;
        }
        
        .lazy-image {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        
        .lazy-image.loaded {
            opacity: 1;
        }
        
        .lazy-image.error {
            opacity: 0.5;
            filter: grayscale(100%);
        }
        
       
        .lazy-image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: loading 1.5s infinite;
            z-index: 1;
        }
        
        .lazy-image.loaded + .lazy-image-container::before {
            display: none;
        }
        
        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }
    </style>
    @endpush
@endonce