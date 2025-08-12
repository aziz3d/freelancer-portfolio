{{-- Hero Background Animations --}}
@php
    $animationPreset = $hero['meta']['animation_preset'] ?? 'default';
@endphp

{{-- Default Creative Animation --}}
<div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-r from-primary-100/30 via-transparent to-accent-100/30"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-secondary-50/20 to-transparent"></div>
    <div class="absolute -top-10 -left-20 w-40 h-40 bg-gradient-to-br from-primary-200 to-primary-300 rounded-full opacity-40 animate-float-slow blur-sm"></div>
    <div class="absolute top-20 left-1/4 w-32 h-32 bg-gradient-to-br from-secondary-200 to-secondary-300 rounded-lg opacity-50 animate-float-medium transform rotate-45 blur-sm"></div>
    <div class="absolute top-40 right-1/4 w-28 h-28 bg-gradient-to-br from-accent-200 to-accent-300 rounded-full opacity-45 animate-float-fast blur-sm"></div>
    <div class="absolute -top-5 -right-15 w-36 h-36 bg-gradient-to-br from-primary-100 to-secondary-200 rounded-lg opacity-35 animate-float-slow transform rotate-12 blur-sm"></div>
    
    <div class="absolute bottom-40 left-10 w-24 h-24 bg-gradient-to-br from-accent-300 to-primary-300 rounded-full opacity-60 animate-float-medium"></div>
    <div class="absolute bottom-20 right-20 w-20 h-20 bg-gradient-to-br from-secondary-300 to-accent-300 rounded-lg opacity-55 animate-float-fast transform rotate-45"></div>
    <div class="absolute top-1/3 left-1/6 w-16 h-16 bg-gradient-to-br from-primary-300 to-secondary-300 rounded-full opacity-50 animate-float-slow"></div>
    <div class="absolute bottom-1/3 right-1/6 w-18 h-18 bg-gradient-to-br from-accent-300 to-primary-300 rounded-lg opacity-45 animate-float-medium transform rotate-30"></div>
    
    <div class="absolute top-1/4 left-1/5 w-48 h-48 bg-gradient-to-r from-primary-300/40 to-secondary-300/40 rounded-full animate-pulse-slow blur-2xl"></div>
    <div class="absolute bottom-1/4 right-1/5 w-56 h-56 bg-gradient-to-r from-secondary-300/35 to-accent-300/35 rounded-full animate-pulse-medium blur-2xl"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-accent-200/25 to-primary-200/25 rounded-full animate-pulse-slow blur-3xl"></div>
    
    <svg class="absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800">
        <defs>
            <linearGradient id="lineGradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:rgb(59,130,246);stop-opacity:0.4" />
                <stop offset="50%" style="stop-color:rgb(147,51,234);stop-opacity:0.2" />
                <stop offset="100%" style="stop-color:rgb(236,72,153);stop-opacity:0.3" />
            </linearGradient>
            <linearGradient id="lineGradient2" x1="100%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" style="stop-color:rgb(236,72,153);stop-opacity:0.3" />
                <stop offset="50%" style="stop-color:rgb(59,130,246);stop-opacity:0.2" />
                <stop offset="100%" style="stop-color:rgb(147,51,234);stop-opacity:0.4" />
            </linearGradient>
        </defs>

        <path d="M0,150 Q300,100 600,150 T1200,150" stroke="url(#lineGradient1)" stroke-width="3" fill="none" opacity="0.6">
            <animate attributeName="stroke-dasharray" values="0,2000;2000,0;0,2000" dur="12s" repeatCount="indefinite"/>
        </path>
        <path d="M0,300 Q400,250 800,300 T1200,300" stroke="url(#lineGradient2)" stroke-width="2" fill="none" opacity="0.5">
            <animate attributeName="stroke-dasharray" values="0,1800;1800,0;0,1800" dur="15s" repeatCount="indefinite"/>
        </path>
        <path d="M0,450 Q200,400 400,450 T800,450 Q1000,400 1200,450" stroke="url(#lineGradient1)" stroke-width="2.5" fill="none" opacity="0.4">
            <animate attributeName="stroke-dasharray" values="0,2200;2200,0;0,2200" dur="18s" repeatCount="indefinite"/>
        </path>
        <path d="M0,600 Q600,550 1200,600" stroke="url(#lineGradient2)" stroke-width="1.5" fill="none" opacity="0.3">
            <animate attributeName="stroke-dasharray" values="0,1500;1500,0;0,1500" dur="20s" repeatCount="indefinite"/>
        </path>
    </svg>
    
    <div class="absolute top-1/4 left-1/8 w-3 h-3 bg-primary-400 rounded-full opacity-60 animate-float-fast"></div>
    <div class="absolute top-1/3 right-1/8 w-2 h-2 bg-secondary-400 rounded-full opacity-70 animate-float-medium"></div>
    <div class="absolute bottom-1/4 left-1/3 w-4 h-4 bg-accent-400 rounded-full opacity-50 animate-float-slow"></div>
    <div class="absolute bottom-1/3 right-1/3 w-3 h-3 bg-primary-500 rounded-full opacity-65 animate-float-fast"></div>
    <div class="absolute top-2/3 left-1/6 w-2 h-2 bg-secondary-500 rounded-full opacity-55 animate-float-medium"></div>
    <div class="absolute top-3/4 right-1/6 w-3 h-3 bg-accent-500 rounded-full opacity-60 animate-float-slow"></div>
    
    <div class="absolute top-24 right-16 text-primary-400 opacity-40 font-mono text-lg font-bold animate-fade-in-out">
        &lt;/&gt;
    </div>
    <div class="absolute bottom-24 left-20 text-secondary-400 opacity-45 font-mono text-base font-bold animate-fade-in-out-delayed">
        { }
    </div>
    <div class="absolute top-1/2 right-1/4 text-accent-400 opacity-50 font-mono text-2xl font-bold animate-fade-in-out-slow">
        3D
    </div>
    <div class="absolute top-1/3 left-1/5 text-primary-500 opacity-35 font-mono text-sm animate-fade-in-out">
        function()
    </div>
    <div class="absolute bottom-1/3 right-1/5 text-secondary-500 opacity-40 font-mono text-base animate-fade-in-out-delayed">
        .render()
    </div>
    
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(59,130,246,0.3) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
</div>