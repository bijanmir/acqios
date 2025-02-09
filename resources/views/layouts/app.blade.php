<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph Meta Tags for Social Media Previews -->
    <meta property="og:title" content="{{ $ogTitle ?? config('app.name', 'Laravel') }}">
    <meta property="og:description" content="{{ $ogDescription ?? 'Discover amazing listings on our platform.' }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('default-preview.jpg') }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card for Twitter Previews -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle ?? config('app.name', 'Laravel') }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? 'Discover amazing listings on our platform.' }}">
    <meta name="twitter:image" content="{{ $ogImage ?? asset('default-preview.jpg') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">
<div class="flex flex-col min-h-screen">
    @include('layouts.navigation')

    <!-- Page Heading (Sticky Header with Glassmorphism) -->
    @isset($header)
        <header class="sticky top-0 z-20 bg-white/60 dark:bg-gray-800/60 shadow-md backdrop-blur-md border-b border-white/40 dark:border-gray-700">
            <div class="max-w-7xl mx-auto p-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer (Glassmorphic Style) -->
    <footer class="py-4 bg-white/60 dark:bg-gray-800/60 text-center backdrop-blur-md border-t border-white/40 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-sm text-gray-600 dark:text-gray-300">
                © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Last Updated:
                @php
                    $lastUpdatedFile = storage_path('logs/last_updated.log');
                    echo file_exists($lastUpdatedFile) ? file_get_contents($lastUpdatedFile) : 'Not Available';
                @endphp
            </p>
        </div>
    </footer>
</div>
</body>
</html>
