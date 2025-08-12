@extends('layouts.app')

@section('title', 'Contact - Aziz Khan')
@section('meta_description', 'Get in touch with Aziz Khan for web development, 3D modeling, and design projects. Let\'s discuss your next project.')

@if($contactRecaptcha['meta']['enabled'] ?? false)
    @if(($contactRecaptcha['meta']['version'] ?? 'v2') === 'v2')
        @push('head')
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endpush
    @else
        @push('head')
            <script src="https://www.google.com/recaptcha/api.js?render={{ $contactRecaptcha['meta']['site_key'] ?? '' }}"></script>
        @endpush
    @endif
@endif

@section('content')
<x-page-header 
    title="{{ $pageTitle['title'] ?? 'Get In Touch' }}" 
    description="{{ $pageTitle['content'] ?? 'Have a project in mind? I\'d love to hear from you. Send me a message and I\'ll respond as soon as possible.' }}"
    subtitle="{{ $pageTitle['meta']['subtitle'] ?? null }}">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Send Message</h2>
                
       
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <input type="text" name="honeypot" style="display: none;" tabindex="-1" autocomplete="off">
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Name <span class="text-red-500" aria-label="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            class="w-full px-3 sm:px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 touch-manipulation @error('name') border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Your full name"
                            required
                            aria-describedby="@error('name') name-error @enderror"
                            autocomplete="name"
                        >
                        @error('name')
                            <p id="name-error" class="mt-1 text-sm text-red-600" role="alert">
                                <span class="sr-only">Error:</span>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500" aria-label="required">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-3 sm:px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 touch-manipulation @error('email') border-red-500 focus:ring-red-500 @enderror"
                            placeholder="your.email@example.com"
                            required
                            aria-describedby="@error('email') email-error @enderror"
                            autocomplete="email"
                        >
                        @error('email')
                            <p id="email-error" class="mt-1 text-sm text-red-600" role="alert">
                                <span class="sr-only">Error:</span>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Subject
                        </label>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject" 
                            value="{{ old('subject') }}"
                            class="w-full px-3 sm:px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 touch-manipulation @error('subject') border-red-500 focus:ring-red-500 @enderror"
                            placeholder="What's this about?"
                            aria-describedby="@error('subject') subject-error @enderror"
                        >
                        @error('subject')
                            <p id="subject-error" class="mt-1 text-sm text-red-600" role="alert">
                                <span class="sr-only">Error:</span>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message <span class="text-red-500" aria-label="required">*</span>
                        </label>
                        <textarea 
                            id="message" 
                            name="message" 
                            rows="6"
                            class="w-full px-3 sm:px-4 py-3 text-sm sm:text-base border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 resize-y touch-manipulation @error('message') border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Tell me about your project or inquiry..."
                            required
                            minlength="10"
                            aria-describedby="message-help @error('message') message-error @enderror"
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <p id="message-error" class="mt-1 text-sm text-red-600" role="alert">
                                <span class="sr-only">Error:</span>{{ $message }}
                            </p>
                        @enderror
                        <p id="message-help" class="mt-1 text-sm text-gray-500">Minimum 10 characters required</p>
                    </div>

                    @if($contactRecaptcha['meta']['enabled'] ?? false)
                        <div class="flex justify-center">
                            @if(($contactRecaptcha['meta']['version'] ?? 'v2') === 'v2')
                                <div class="g-recaptcha" data-sitekey="{{ $contactRecaptcha['meta']['site_key'] ?? '' }}"></div>
                            @endif
                        </div>
                    @endif

                    <div>
                        <button 
                            type="submit"
                            id="submit-btn"
                            class="w-full bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 focus:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium text-sm sm:text-base touch-manipulation focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed"
                            aria-describedby="submit-help"
                        >
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send Message
                            </span>
                        </button>
                        <p id="submit-help" class="mt-2 text-xs text-gray-500 text-center">
                            {{ $contactInfo['meta']['response_time'] ?? "I'll respond within 24 hours" }}
                        </p>
                    </div>
                </form>
            </div>


            <div class="space-y-8">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ $contactInfo['title'] ?? 'Contact Information' }}</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Email</p>
                                <p class="text-sm text-gray-600">{{ $contactInfo['meta']['email'] ?? 'aziz@example.com' }}</p>
                            </div>
                        </div>

                        @if(!empty($contactInfo['meta']['phone']))
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Phone</p>
                                    <p class="text-sm text-gray-600">{{ $contactInfo['meta']['phone'] }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Location</p>
                                <p class="text-sm text-gray-600">{{ $contactInfo['meta']['location'] ?? 'Available for remote work' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Response Time</p>
                                <p class="text-sm text-gray-600">{{ $contactInfo['meta']['response_time'] ?? 'Usually within 24 hours' }}</p>
                            </div>
                        </div>

                        @if(($contactInfo['meta']['availability'] ?? 'available') !== 'available')
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Availability</p>
                                    <p class="text-sm text-orange-600">
                                        {{ $contactInfo['meta']['availability'] === 'busy' ? 'Currently busy' : 'Not available for new projects' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ $contactSocial['title'] ?? 'Connect With Me' }}</h2>
                    
                    @if(!empty($contactSocial['content']))
                        <p class="text-gray-600 mb-6">{{ $contactSocial['content'] }}</p>
                    @endif
                    
                    <div class="grid grid-cols-1 gap-4">
                        @php
                            $socialLinks = $contactSocial['meta']['social_links'] ?? [];
                            $socialPlatforms = [
                                'linkedin' => ['name' => 'LinkedIn', 'color' => 'blue-600', 'description' => 'Professional network & experience'],
                                'github' => ['name' => 'GitHub', 'color' => 'gray-800', 'description' => 'Code repositories & projects'],
                                'twitter' => ['name' => 'Twitter', 'color' => 'blue-400', 'description' => 'Latest updates & thoughts'],
                                'instagram' => ['name' => 'Instagram', 'color' => 'pink-600', 'description' => 'Behind the scenes'],
                                'facebook' => ['name' => 'Facebook', 'color' => 'blue-600', 'description' => 'Connect & updates'],
                                'youtube' => ['name' => 'YouTube', 'color' => 'red-600', 'description' => 'Video content & tutorials'],
                                'behance' => ['name' => 'Behance', 'color' => 'blue-500', 'description' => 'Creative portfolio'],
                                'dribbble' => ['name' => 'Dribbble', 'color' => 'pink-500', 'description' => 'Design shots & inspiration'],
                                'medium' => ['name' => 'Medium', 'color' => 'gray-800', 'description' => 'Articles & insights'],
                                'dev' => ['name' => 'Dev.to', 'color' => 'gray-800', 'description' => 'Developer community'],
                                'stackoverflow' => ['name' => 'Stack Overflow', 'color' => 'orange-500', 'description' => 'Q&A and solutions'],
                                'discord' => ['name' => 'Discord', 'color' => 'indigo-600', 'description' => 'Community & chat'],
                                'telegram' => ['name' => 'Telegram', 'color' => 'blue-500', 'description' => 'Direct messaging']
                            ];
                        @endphp
                        
                        @foreach($socialLinks as $platform => $url)
                            @if(!empty($url) && isset($socialPlatforms[$platform]))
                                @php $platformData = $socialPlatforms[$platform]; @endphp
                                <a 
                                    href="{{ $url }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-{{ $platformData['color'] }} hover:bg-gray-50 transition duration-200 group"
                                >
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 bg-{{ $platformData['color'] }} rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-bold">
                                                {{ strtoupper(substr($platformData['name'], 0, 1)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-{{ $platformData['color'] }}">{{ $platformData['name'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $platformData['description'] }}</p>
                                    </div>
                                    <div class="ml-auto">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-{{ $platformData['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                        
                        @if(empty($socialLinks) || count(array_filter($socialLinks)) === 0)
                            <div class="text-center py-8">
                                <p class="text-gray-500">No social media links configured yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    </div>
</x-page-header>

@if($contactRecaptcha['meta']['enabled'] ?? false)
    @if(($contactRecaptcha['meta']['version'] ?? 'v2') === 'v3')
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.querySelector('form[action="{{ route('contact.store') }}"]');
                    const submitBtn = document.getElementById('submit-btn');
                    
                    if (form && submitBtn) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            
                            grecaptcha.ready(function() {
                                grecaptcha.execute('{{ $contactRecaptcha['meta']['site_key'] ?? '' }}', {action: 'contact_form'}).then(function(token) {
                                    let tokenInput = document.createElement('input');
                                    tokenInput.type = 'hidden';
                                    tokenInput.name = 'g-recaptcha-response';
                                    tokenInput.value = token;
                                    form.appendChild(tokenInput);
                                    form.submit();
                                });
                            });
                        });
                    }
                });
            </script>
        @endpush
    @endif
@endif
@endsection