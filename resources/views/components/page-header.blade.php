@props(['title', 'description', 'subtitle' => null])

<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            @if($subtitle)
                <p class="text-lg text-primary-600 font-medium mb-2">{{ $subtitle }}</p>
            @endif
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $title }}</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ $description }}
            </p>
        </div>
        
        {{ $slot }}
    </div>
</div>