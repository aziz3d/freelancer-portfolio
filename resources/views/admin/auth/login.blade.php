<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login - {{ $siteBranding['title'] ?? 'Aziz Khan Portfolio' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Admin Login</h1>
            </div>

            <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-sm font-medium text-blue-800">Admin Credentials</h3>
                </div>
                <div class="text-sm text-blue-700">
                    <div class="mb-1">
                        <span class="font-semibold">Email:</span>
                        <code class="bg-blue-100 px-2 py-1 rounded text-blue-900 font-mono">admin@portfolio.com</code>
                    </div>
                    <div>
                        <span class="font-semibold">Password:</span>
                        <code class="bg-blue-100 px-2 py-1 rounded text-blue-900 font-mono">azizkhan</code>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                    role="alert">
                    @if (session('session_expired'))
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <strong>Session Expired:</strong> {{ session('error') }}
                                <br><small class="text-red-600">For security, admin sessions expire after 30 minutes of
                                    inactivity.</small>
                            </div>
                        </div>
                    @else
                        <span class="block sm:inline">{{ session('error') }}</span>
                    @endif
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input id="email"
                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                        type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                    <input id="password"
                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                        type="password" name="password" required autocomplete="current-password" />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="block mt-4">
                    <label for="remember" class="inline-flex items-center">
                        <input id="remember" type="checkbox"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('admin.password.request') }}"
                        class="text-sm text-blue-600 hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Forgot your password?
                    </a>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('home') }}"
                        class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        ← Back to Site
                    </a>

                    <button type="submit"
                        class="ml-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Log in
                    </button>
                </div>
            </form>
        </div>

        <footer class="mt-8 text-center text-sm text-gray-500">
            <p>
                @if (isset($footer['meta']['copyright']))
                    {{ $footer['meta']['copyright'] }}
                @else
                    &copy; {{ date('Y') }} {{ config('app.name', 'Portfolio') }}. All rights reserved.
                @endif
            </p>

        </footer>
    </div>
</body>

</html>
