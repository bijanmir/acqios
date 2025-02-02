<x-guest-layout>

    <!-- 🌟 Hero Section -->
    <div class="h-screen min-h-[650px] bg-gradient-to-r from-blue-600 via-purple-600 to-pink-500 flex flex-col justify-center items-center text-center text-white px-8 relative bg-cover bg-center dark:bg-gray-900"
         style="background-image: url('/images/sd_skyline.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50 dark:bg-opacity-60"></div> <!-- Dark mode overlay for contrast -->
        <div class="relative z-10">
            <h1 class="text-6xl sm:text-8xl font-black drop-shadow-xl">Buy & Sell Businesses with Ease</h1>
            <p class="mt-6 text-xl sm:text-2xl max-w-2xl mx-auto text-gray-200 dark:text-gray-300">
                The leading marketplace for entrepreneurs looking to buy or sell businesses securely.
            </p>
            <a href="{{ route('register') }}" class="mt-8 px-10 py-4 bg-white text-blue-700 font-bold rounded-full shadow-xl hover:shadow-2xl hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition ease-in-out duration-300 inline-block">
                Get Started Now
            </a>
        </div>
    </div>

    <!-- 🛠 Features Section -->
    <section id="features" class="py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto text-center px-6">
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white">Why Choose Acqios?</h2>
            <p class="mt-6 text-lg text-gray-600 dark:text-gray-400">The best features to help you buy and sell businesses effortlessly.</p>

            <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-10">
                <div class="p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 transition transform hover:scale-105 hover:shadow-3xl">
                    <h3 class="text-2xl font-semibold flex items-center dark:text-white">
                        <svg class="w-10 h-10 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.343-4.343M21 21l-4.343-4.343"></path><circle cx="12" cy="12" r="9"></circle><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l-8-8m8 0l-8 8"></path></svg>
                        Verified Listings
                    </h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">Every business listing is verified for trust and transparency.</p>
                </div>
                <div class="p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 transition transform hover:scale-105 hover:shadow-3xl">
                    <h3 class="text-2xl font-semibold flex items-center dark:text-white">
                        <svg class="w-10 h-10 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Expert Assistance
                    </h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">Our 24/7 support team helps you with every step.</p>
                </div>
                <div class="p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 transition transform hover:scale-105 hover:shadow-3xl">
                    <h3 class="text-2xl font-semibold flex items-center dark:text-white">
                        <svg class="w-10 h-10 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Secure Payments
                    </h3>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">We ensure all transactions are secure and hassle-free.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 🎯 Call-to-Action -->
    <section class="py-20 bg-gradient-to-r from-purple-500 via-blue-500 to-indigo-600 text-white text-center dark:bg-gray-900">
        <h2 class="text-4xl font-bold">Join Thousands of Successful Entrepreneurs</h2>
        <p class="mt-6 text-lg text-gray-100 dark:text-gray-300">Create your free account and start exploring today.</p>
        <a href="{{ route('register') }}" class="mt-6 inline-block px-10 py-4 bg-white text-blue-700 font-bold rounded-full shadow-lg hover:shadow-xl hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition ease-in-out duration-300">
            Sign Up for Free
        </a>
    </section>

    <!-- 🏆 Testimonials -->
    <section class="py-20 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto text-center px-6">
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white">What Our Users Say</h2>
            <div class="mt-16 grid grid-cols-1 sm:grid-cols-3 gap-10">
                <div class="p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <p class="text-lg text-gray-600 dark:text-gray-400">"I sold my business within two weeks! The best platform for entrepreneurs."</p>
                    <h4 class="mt-4 font-bold text-gray-900 dark:text-white">- Sarah J.</h4>
                </div>
                <div class="p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <p class="text-lg text-gray-600 dark:text-gray-400">"The process was smooth, and I found my dream business easily."</p>
                    <h4 class="mt-4 font-bold text-gray-900 dark:text-white">- Mark R.</h4>
                </div>
                <div class="p-8 bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <p class="text-lg text-gray-600 dark:text-gray-400">"Secure transactions and great customer support. Highly recommend!"</p>
                    <h4 class="mt-4 font-bold text-gray-900 dark:text-white">- Jessica T.</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- 📢 SEO & Footer -->
    <footer class="py-12 bg-gray-900 dark:bg-black text-white text-center">
        <p class="text-lg">© 2025 Acqios. All rights reserved.</p>
        <div class="mt-4 flex justify-center space-x-6">
            <a href="#" class="text-lg hover:text-blue-400">Privacy Policy</a>
            <a href="#" class="text-lg hover:text-blue-400">Terms of Service</a>
            <a href="#" class="text-lg hover:text-blue-400">Contact</a>
        </div>
    </footer>

</x-guest-layout>
