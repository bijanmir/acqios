<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
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
    <meta name="theme-color" content="#4F46E5" />
    <meta name="application-name" content="Acqios" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="apple-mobile-web-app-title" content="Acqios" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="mobile-web-app-capable" content="yes" />

    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title', config('app.name', 'Acqios - Business Marketplace'))" />
    <meta property="og:description" content="Acqios is the best online marketplace to buy or list a business for sale." />
    <meta property="og:site_name" content="Acqios" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">

    <title>@yield('title', config('app.name', 'Acqios - Business Marketplace'))</title>

    <!-- Preload critical assets -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full overflow-x-hidden bg-gray-100 dark:bg-gray-900">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WTQRX674"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="min-h-screen flex flex-col">
    <!-- Status Messages (if any) -->
    @if (session('success') || session('error') || session('status'))
        <div id="notification" class="fixed top-4 right-4 z-50 max-w-sm">
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 shadow-md rounded-lg dark:bg-green-900/30 dark:border-green-600">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 shadow-md rounded-lg dark:bg-red-900/30 dark:border-red-600">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('status'))
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 shadow-md rounded-lg dark:bg-blue-900/30 dark:border-blue-600">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700 dark:text-blue-300">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <script>
            // Auto-hide notifications after 5 seconds
            setTimeout(function() {
                const notification = document.getElementById('notification');
                if (notification) {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 1s ease';
                    setTimeout(() => notification.remove(), 1000);
                }
            }, 5000);
        </script>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Simple Footer for Guest Pages -->
    <footer class="py-4 text-center text-sm text-gray-500 dark:text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex w-full justify-center">
                <div class="mb-0">
                    &copy; {{ date('Y') }} Acqios. All rights reserved.
                </div>
                <div class="flex space-x-6">
                    <!-- Only include links that exist in your application -->
                    @if(Route::has('terms'))
                        <a href="{{ route('terms') }}" class="hover:text-gray-900 dark:hover:text-gray-300">Terms</a>
                    @endif

                    @if(Route::has('privacy'))
                        <a href="{{ route('privacy') }}" class="hover:text-gray-900 dark:hover:text-gray-300">Privacy</a>
                    @endif

                    @if(Route::has('contact'))
                        <a href="{{ route('contact') }}" class="hover:text-gray-900 dark:hover:text-gray-300">Contact</a>
                    @endif

                    <!-- Alternative: Use hardcoded URLs if you prefer -->
                    <!--
                    <a href="/terms" class="hover:text-gray-900 dark:hover:text-gray-300">Terms</a>
                    <a href="/privacy" class="hover:text-gray-900 dark:hover:text-gray-300">Privacy</a>
                    <a href="/contact" class="hover:text-gray-900 dark:hover:text-gray-300">Contact</a>
                    -->
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Custom Script for Dark Mode Toggle if needed -->
<script>
    // Check for dark mode preference
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }
</script>
</body>
</html>
