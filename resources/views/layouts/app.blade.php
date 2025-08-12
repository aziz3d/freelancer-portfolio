<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="{{ $siteBranding['meta']['brand_color'] ?? '#2563eb' }}">
    <meta name="color-scheme" content="light">

    @include('partials.seo-meta')
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{ asset('css/hero-animations.css') }}">


    <style>
        :root {
            --brand-color: {{ $siteBranding['meta']['brand_color'] ?? '#3b82f6' }};
            --brand-color-rgb: {{
                isset($siteBranding['meta']['brand_color'])
                    ? implode(', ', sscanf($siteBranding['meta']['brand_color'], "#%02x%02x%02x"))
                    : '59, 130, 246'
            }};
        }

        .btn-primary,
        .bg-primary-600,
        .bg-primary-500 {
            background-color: var(--brand-color) !important;
        }

        .btn-primary:hover,
        .hover\:bg-primary-700:hover,
        .hover\:bg-primary-600:hover,
        .focus\:bg-primary-700:focus {
            background-color: color-mix(in srgb, var(--brand-color) 85%, black) !important;
        }

        .text-primary-600,
        .text-primary-500 {
            color: var(--brand-color) !important;
        }

        .hover\:text-primary-600:hover,
        .focus\:text-primary-600:focus {
            color: var(--brand-color) !important;
        }

        .border-primary-600,
        .border-primary-500 {
            border-color: var(--brand-color) !important;
        }

        .border-b-2.border-primary-600 {
            border-bottom-color: var(--brand-color) !important;
        }

        .ring-primary-500,
        .focus\:ring-primary-500:focus,
        .focus\:ring-primary-600:focus {
            --tw-ring-color: rgba(var(--brand-color-rgb), 0.5) !important;
        }

        .bg-gradient-to-r.from-primary-600,
        .bg-gradient-to-br.from-primary-500 {
            --tw-gradient-from: var(--brand-color) var(--tw-gradient-from-position) !important;
        }

        .text-gradient {
            background: linear-gradient(to right, var(--brand-color), #d946ef) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }

        .nav-link.text-primary-600 {
            color: var(--brand-color) !important;
        }

        .bg-primary-600.text-white {
            background-color: var(--brand-color) !important;
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-900 overflow-x-hidden">
    <a href="#main-content" 
       class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary-600 text-white px-4 py-2 rounded-md z-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
        Skip to main content
    </a>

    <div class="min-h-screen flex flex-col">
        <x-navbar />

        <main id="main-content" class="flex-1" role="main">
            @yield('content')
        </main>

        <x-footer />
    </div>

    <div id="sr-announcements" class="sr-only" aria-live="polite" aria-atomic="true"></div>

    @stack('scripts')
</body>
</html>