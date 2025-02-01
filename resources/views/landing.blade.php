<x-guest-layout>

    <!-- 🌟 Hero Section -->
    <div class="h-[65vh] bg-gradient-to-r from-blue-600 via-purple-600 to-pink-500 flex flex-col justify-center items-center text-center text-white px-6 relative bg-cover bg-center dark:bg-gray-900"
         style="background-image: url('/images/sd_skyline.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-30 dark:bg-opacity-40"></div> <!-- Dark mode overlay for contrast -->
        <div class="relative z-10">
            <h1 class="text-5xl font-extrabold drop-shadow-lg">Buy & Sell Businesses with Ease</h1>
            <p class="mt-4 text-lg max-w-xl mx-auto text-gray-200 dark:text-gray-300">
                The leading marketplace for entrepreneurs looking to buy or sell businesses securely.
            </p>
            <a href="{{ route('register') }}" class="mt-6 px-8 py-3 bg-white text-blue-700 font-semibold rounded-lg shadow-lg hover:bg-gray-200 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition inline-block">
                Get Started Now
            </a>
        </div>
    </div>



    <!-- 🛠 Features Section -->
    <section id="features" class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-6xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Why Choose Acqios?</h2>
            <p class="mt-4 text-gray-600 dark:text-gray-400">The best features to help you buy and sell businesses effortlessly.</p>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-8">
                <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg border border-gray-300 dark:border-gray-700 transition transform hover:scale-105">
                    <h3 class="text-xl font-semibold flex items-center">
                        🔍 Verified Listings
                    </h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Every business listing is verified for trust and transparency.</p>
                </div>
                <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg border border-gray-300 dark:border-gray-700 transition transform hover:scale-105">
                    <h3 class="text-xl font-semibold flex items-center">
                        💡 Expert Assistance
                    </h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Our 24/7 support team helps you with every step.</p>
                </div>
                <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg border border-gray-300 dark:border-gray-700 transition transform hover:scale-105">
                    <h3 class="text-xl font-semibold flex items-center">
                        💳 Secure Payments
                    </h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">We ensure all transactions are secure and hassle-free.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 🎯 Call-to-Action -->
    <section class="py-16 bg-gradient-to-r from-purple-500 via-blue-500 to-indigo-600 text-white text-center dark:bg-gray-900">
        <h2 class="text-3xl font-bold">Join Thousands of Successful Entrepreneurs</h2>
        <p class="mt-4 text-lg text-gray-100 dark:text-gray-300">Create your free account and start exploring today.</p>
        <a href="{{ route('register') }}" class="mt-6 inline-block px-8 py-3 bg-white text-blue-700 font-semibold rounded-lg shadow-lg hover:bg-gray-200 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition">
            Sign Up for Free
        </a>
    </section>

    <!-- 🏆 Testimonials -->
    <section class="py-16 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">What Our Users Say</h2>
            <div class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-8">
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-300 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-400">"I sold my business within two weeks! The best platform for entrepreneurs."</p>
                    <h4 class="mt-4 font-semibold text-gray-900 dark:text-white">- Sarah J.</h4>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-300 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-400">"The process was smooth, and I found my dream business easily."</p>
                    <h4 class="mt-4 font-semibold text-gray-900 dark:text-white">- Mark R.</h4>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-300 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-400">"Secure transactions and great customer support. Highly recommend!"</p>
                    <h4 class="mt-4 font-semibold text-gray-900 dark:text-white">- Jessica T.</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- 📢 SEO & Footer -->
    <footer class="py-12 bg-gray-900 dark:bg-black text-white text-center">
        <p class="text-lg">&copy; 2025 Acqios. All rights reserved.</p>
        <div class="mt-4 flex justify-center space-x-6">
            <a href="#" class="hover:text-blue-400">Privacy Policy</a>
            <a href="#" class="hover:text-blue-400">Terms of Service</a>
            <a href="#" class="hover:text-blue-400">Contact</a>
        </div>
    </footer>

</x-guest-layout>
