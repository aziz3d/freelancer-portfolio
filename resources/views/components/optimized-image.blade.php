@props([
    'path' => '',
    'alt' => '',
    'class' => '',
    'loading' => 'lazy',
    'width' => null,
    'height' => null,
    'thumbnail' => false,
    'preferWebp' => true
])

@php
    $imageService = app(\App\Services\ImageService::class);
    
    if ($thumbnail) {
        $urls = $imageService->getThumbnailUrl($path, $preferWebp);
    } else {
        $urls = $imageService->getImageUrl($path, $preferWebp);
    }
    
    $webpUrl = $urls['webp'] ?? null;
    $originalUrl = $urls['original'];
@endphp

<x-lazy-image 
    :src="$originalUrl"
    :webp="$webpUrl"
    :alt="$alt"
    :class="$class"
    :loading="$loading"
    :width="$width"
    :height="$height"
    {{ $attributes->except(['path', 'alt', 'class', 'loading', 'width', 'height', 'thumbnail', 'preferWebp']) }}
/>