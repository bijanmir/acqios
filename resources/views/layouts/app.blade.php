@props(['ogTitle' => config('app.name', 'Laravel'), 'ogDescription' => 'Discover amazing listings on our platform.', 'ogImage' => asset('default-preview.jpg')])

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WTQRX674');</script>
    <!-- End Google Tag Manager -->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9WJDPJ51L8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-9WJDPJ51L8');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Acqios is the best online marketplace to buy or list a business for sale. Discover verified listings, attract serious buyers, and close deals faster." />

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

    <!-- Ensure the Title Updates -->
    <title>@yield('title', $ogTitle ?? config('app.name', 'Laravel'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WTQRX674"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
        </div>
    </footer>
</div>
</body>
</html>
