{{-- Dynamic SEO Meta Tags --}}
@php
    $seo = $seoData ?? [];
    $siteTitle = $siteBranding['title'] ?? 'Aziz Khan';
    $siteDescription = $siteBranding['content'] ?? 'Professional portfolio showcasing expertise in web development, design, and digital solutions.';
    $siteKeywords = $siteBranding['meta']['meta_keywords'] ?? '2D Artist, 3D Artist, Web Developer, Laravel, 3ds Max, UI/UX Design, Portfolio, Aziz Khan';
    $siteAuthor = $siteBranding['meta']['meta_author'] ?? 'Aziz Khan';

    // Use the site title from branding settings as-is
    $title = $seo['title'] ?? $title ?? $siteTitle;
    $description = $seo['description'] ?? $description ?? $siteDescription;
    $keywords = $seo['keywords'] ?? $keywords ?? $siteKeywords;
    $ogType = $seo['ogType'] ?? $ogType ?? 'website';
    $ogUrl = $seo['ogUrl'] ?? $ogUrl ?? url()->current();
    $ogImage = $seo['ogImage'] ?? $ogImage ?? asset('images/og-default.jpg');
    $canonical = $seo['canonical'] ?? $canonical ?? url()->current();
    $robots = $seo['robots'] ?? $robots ?? 'index, follow';
    $structuredData = $seo['structuredData'] ?? $structuredData ?? null;
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $siteAuthor }}">

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $ogUrl }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="{{ $siteTitle }} Portfolio">

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">

{{-- Additional Meta Tags --}}
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonical }}">

{{-- Favicon --}}
@if(isset($siteBranding['meta']['favicon']) && $siteBranding['meta']['favicon'])
    <link rel="icon" type="image/x-icon" href="{{ $siteBranding['meta']['favicon'] }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $siteBranding['meta']['favicon'] }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $siteBranding['meta']['favicon'] }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $siteBranding['meta']['favicon'] }}">
@else
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
@endif

{{-- Structured Data --}}
@if($structuredData)
<script type="application/ld+json">
{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif