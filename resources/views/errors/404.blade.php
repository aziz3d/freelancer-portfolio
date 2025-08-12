@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-secondary-50 flex items-center justify-center px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 text-primary-200 text-9xl font-bold opacity-20 animate-float-slow">4</div>
        <div class="absolute top-32 right-32 text-secondary-200 text-9xl font-bold opacity-20 animate-float-medium">0</div>
        <div class="absolute bottom-32 left-1/3 text-accent-200 text-9xl font-bold opacity-20 animate-float-fast">4</div>
        <div class="absolute top-40 left-1/4 w-16 h-16 bg-gradient-to-br from-primary-300 to-primary-400 rounded-full opacity-30 animate-bounce-slow"></div>
        <div class="absolute bottom-40 right-1/4 w-12 h-12 bg-gradient-to-br from-secondary-300 to-secondary-400 transform rotate-45 opacity-40 animate-spin-slow"></div>
        <div class="absolute top-1/2 right-20 w-8 h-20 bg-gradient-to-b from-accent-300 to-accent-400 opacity-35 animate-pulse"></div>
        <div class="absolute top-24 right-24 text-primary-300 text-4xl opacity-40 animate-bounce">?</div>
        <div class="absolute bottom-24 left-24 text-secondary-300 text-3xl opacity-30 animate-pulse">?</div>
        
        <div class="absolute top-1/3 left-16 text-gray-300 opacity-20 animate-fade-in-out">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 7h2.5L9 8.5 7.5 7H8zm-3 4.5L6.5 10H5v1.5zm6.5 6.5H10l1.5-1.5L13 18h-1.5zm4.5-6.5V10h-1.5L16 11.5zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
            </svg>
        </div>
    </div>

    <div class="max-w-4xl mx-auto text-center relative z-10">
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-4 mb-6">
                <span class="text-8xl sm:text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary-600 via-secondary-600 to-accent-600 animate-pulse">
                    4
                </span>
                <div class="relative">
                    <span class="text-8xl sm:text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-secondary-600 via-accent-600 to-primary-600 animate-spin-slow">
                        0
                    </span>
                    <div class="absolute inset-0 animate-spin">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-primary-400 rounded-full"></div>
                        <div class="absolute top-1/2 -right-4 transform -translate-y-1/2 w-2 h-2 bg-secondary-400 rounded-full"></div>
                        <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-accent-400 rounded-full"></div>
                        <div class="absolute top-1/2 -left-4 transform -translate-y-1/2 w-2 h-2 bg-primary-400 rounded-full"></div>
                    </div>
                </div>
                <span class="text-8xl sm:text-9xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-accent-600 via-primary-600 to-secondary-600 animate-bounce">
                    4
                </span>
            </div>
        </div>

        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                Oops! Page Not Found
            </h1>
            <p class="text-lg sm:text-xl text-gray-600 mb-6 max-w-2xl mx-auto leading-relaxed">
                The page you're looking for seems to have wandered off into the digital void. 
                Don't worry, even the best explorers sometimes take a wrong turn!
            </p>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 sm:p-8 mb-8 shadow-lg border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Here's what you can do:</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 7 5 5 5-5"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Check the URL</h3>
                        <p class="text-sm text-gray-600">Make sure the web address is spelled correctly</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-secondary-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Refresh the page</h3>
                        <p class="text-sm text-gray-600">Sometimes a simple refresh does the trick</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-accent-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Use the search</h3>
                        <p class="text-sm text-gray-600">Try searching for what you're looking for</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Contact me</h3>
                        <p class="text-sm text-gray-600">Let me know if you need help finding something</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Go Home
            </a>
            <a href="{{ route('projects.index') }}" 
               class="inline-flex items-center px-6 py-3 border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                View Projects
            </a>
            <a href="{{ route('contact') }}" 
               class="inline-flex items-center px-6 py-3 text-gray-600 hover:text-primary-600 font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 rounded-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Contact Me
            </a>
        </div>

        <div class="mt-8 text-sm text-gray-500">
            <p>Fun fact: HTTP 404 errors were named after room 404 at CERN where the original web servers were located! 🤓</p>
        </div>
    </div>
</div>

<style>
@keyframes float-slow {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes float-medium {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(-3deg); }
}

@keyframes float-fast {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(2deg); }
}

@keyframes bounce-slow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes fade-in-out {
    0%, 100% { opacity: 0.2; }
    50% { opacity: 0.6; }
}

.animate-float-slow { animation: float-slow 6s ease-in-out infinite; }
.animate-float-medium { animation: float-medium 4s ease-in-out infinite; }
.animate-float-fast { animation: float-fast 3s ease-in-out infinite; }
.animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }
.animate-spin-slow { animation: spin-slow 20s linear infinite; }
.animate-fade-in-out { animation: fade-in-out 3s ease-in-out infinite; }


@media (max-width: 640px) {
    .animate-float-slow,
    .animate-float-medium,
    .animate-float-fast {
        animation-duration: 3s;
    }
}


@media (prefers-reduced-motion: reduce) {
    .animate-float-slow,
    .animate-float-medium,
    .animate-float-fast,
    .animate-bounce-slow,
    .animate-spin-slow,
    .animate-fade-in-out {
        animation: none;
    }
}
</style>
@endsection