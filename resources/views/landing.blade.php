<x-guest-layout>
    <!-- 🌟 Hero Section -->
    <div class="h-screen min-h-[650px] bg-gradient-to-r from-blue-600 via-purple-600 to-pink-500 flex flex-col justify-center items-center text-center text-white px-8 relative bg-cover bg-center dark:bg-gray-900"
         style="background-image: url('/images/sd_skyline.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50 dark:bg-opacity-60"></div> <!-- Dark mode overlay for contrast -->
        <div class="relative z-10">
            <div class="flex justify-center invert w-full pb-10">
                <img src="/images/acqios_logo.png" alt="Acqios Logo" class="w-24 h-24">
            </div>
            <h1 class="text-4xl sm:text-8xl font-black drop-shadow-xl">Buy & Sell Businesses with Ease</h1>
            <p class="mt-6 text-xl sm:text-2xl max-w-2xl mx-auto text-gray-200 dark:text-gray-300">
                The most popular marketplace of 2025 for entrepreneurs to securely buy or sell businesses.
            </p>
            <a href="{{ route('register') }}" class="mt-8 px-10 py-4 bg-white text-blue-700 font-bold rounded-full shadow-xl hover:shadow-2xl hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition ease-in-out duration-300 inline-block">
                Get Started Now
            </a>
        </div>
    </div>
</x-guest-layout>
