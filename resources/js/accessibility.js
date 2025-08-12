
window.A11y = {
    
    announce: function(message, priority = 'polite') {
        const announcer = document.getElementById('sr-announcements');
        if (announcer) {
            announcer.setAttribute('aria-live', priority);
            announcer.textContent = message;
            
            
            setTimeout(() => {
                announcer.textContent = '';
            }, 1000);
        }
    },

    
    focus: {
        
        trap: function(element) {
            const focusableElements = element.querySelectorAll(
                'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select, [tabindex]:not([tabindex="-1"])'
            );
            
            if (focusableElements.length === 0) return;
            
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];
            
            element.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
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
        },

        
        set: function(element, message) {
            if (element) {
                element.focus();
                if (message) {
                    this.announce(message);
                }
            }
        }
    },

    
    keyboard: {
        
        handleArrowNavigation: function(container, itemSelector) {
            const items = Array.from(container.querySelectorAll(itemSelector));
            
            container.addEventListener('keydown', function(e) {
                const currentIndex = items.indexOf(document.activeElement);
                let nextIndex;
                
                switch (e.key) {
                    case 'ArrowDown':
                    case 'ArrowRight':
                        e.preventDefault();
                        nextIndex = (currentIndex + 1) % items.length;
                        items[nextIndex].focus();
                        break;
                    case 'ArrowUp':
                    case 'ArrowLeft':
                        e.preventDefault();
                        nextIndex = currentIndex <= 0 ? items.length - 1 : currentIndex - 1;
                        items[nextIndex].focus();
                        break;
                    case 'Home':
                        e.preventDefault();
                        items[0].focus();
                        break;
                    case 'End':
                        e.preventDefault();
                        items[items.length - 1].focus();
                        break;
                }
            });
        }
    },

   
    theme: {
        
        prefersHighContrast: function() {
            return window.matchMedia('(prefers-contrast: high)').matches;
        },

        
        prefersReducedMotion: function() {
            return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        },

        
        applyHighContrastIfNeeded: function() {
            if (this.prefersHighContrast()) {
                document.documentElement.classList.add('high-contrast');
            }
        }
    },

    
    forms: {
        
        enhanceValidation: function(form) {
            const inputs = form.querySelectorAll('input, textarea, select');
            
            inputs.forEach(input => {
                
                input.addEventListener('blur', function() {
                    if (this.checkValidity()) {
                        this.setAttribute('aria-invalid', 'false');
                        
                        this.classList.remove('border-red-500');
                    } else {
                        this.setAttribute('aria-invalid', 'true');
                       
                        this.classList.add('border-red-500');
                    }
                });

                
                input.addEventListener('input', function() {
                    if (this.getAttribute('aria-invalid') === 'true') {
                        if (this.checkValidity()) {
                            this.setAttribute('aria-invalid', 'false');
                            this.classList.remove('border-red-500');
                        }
                    }
                });
            });
        }
    },

   
    images: {
        
        enhanceImages: function() {
            const images = document.querySelectorAll('img[loading="lazy"]');
            
            images.forEach(img => {
                
                img.addEventListener('loadstart', function() {
                    this.setAttribute('aria-busy', 'true');
                });

                
                img.addEventListener('load', function() {
                    this.removeAttribute('aria-busy');
                });

                
                img.addEventListener('error', function() {
                    this.removeAttribute('aria-busy');
                    this.setAttribute('aria-label', 'Image failed to load');
                });
            });
        }
    }
};


document.addEventListener('DOMContentLoaded', function() {
    
    A11y.theme.applyHighContrastIfNeeded();

    
    const forms = document.querySelectorAll('form');
    forms.forEach(form => A11y.forms.enhanceValidation(form));

    
    A11y.images.enhanceImages();

    
    const cardGrids = document.querySelectorAll('.grid');
    cardGrids.forEach(grid => {
        const cards = grid.querySelectorAll('article a, .card a');
        if (cards.length > 0) {
            A11y.keyboard.handleArrowNavigation(grid, 'article a, .card a');
        }
    });

    
    const skipLinks = document.querySelectorAll('a[href^="#"]');
    skipLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
                target.focus();
                A11y.announce(`Navigated to ${target.textContent || target.getAttribute('aria-label') || 'section'}`);
            }
        });
    });

    
    let isUsingKeyboard = false;
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            isUsingKeyboard = true;
            document.body.classList.add('keyboard-navigation');
        }
    });
    
    document.addEventListener('mousedown', function() {
        isUsingKeyboard = false;
        document.body.classList.remove('keyboard-navigation');
    });

   
    window.addEventListener('orientationchange', function() {
        
        setTimeout(() => {
            const orientation = window.orientation === 0 || window.orientation === 180 ? 'portrait' : 'landscape';
            A11y.announce(`Screen orientation changed to ${orientation}`);
        }, 500);
    });

    
    if (A11y.theme.prefersReducedMotion()) {
        document.documentElement.classList.add('reduce-motion');
    }

    
    const motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    motionQuery.addEventListener('change', function(e) {
        if (e.matches) {
            document.documentElement.classList.add('reduce-motion');
        } else {
            document.documentElement.classList.remove('reduce-motion');
        }
    });
});


export default A11y;