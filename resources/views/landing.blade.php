@section('title', 'List a Business for Sale Online | Acqios Marketplace for Buying & Selling Businesses')

<x-guest-layout>
    <!-- 🌟 Hero Section -->
    <div class="h-screen min-h-[650px] bg-gradient-to-r from-blue-600 via-purple-600 to-pink-500 flex flex-col justify-center items-center text-center text-white px-8 relative bg-cover bg-center dark:bg-gray-900"
         style="background-image: url('/images/sd_skyline.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50 dark:bg-opacity-60"></div> <!-- Dark mode overlay for contrast -->
        <div class="relative z-10 max-w-6xl w-full mx-auto">
            <div class="flex justify-center invert w-full pb-6">
                <img src="/images/acqios_logo.png" alt="Acqios Logo" class="w-24 h-24">
            </div>
            <h1 class="text-4xl sm:text-7xl font-black drop-shadow-xl leading-tight">Buy & Sell Businesses with Confidence</h1>
            <p class="mt-6 text-xl sm:text-2xl max-w-3xl mx-auto text-gray-200 dark:text-gray-300">
                The premier marketplace of 2025 connecting entrepreneurs with verified business opportunities.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="px-10 py-4 bg-white text-blue-700 font-bold rounded-full shadow-xl hover:shadow-2xl hover:bg-gray-100 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition ease-in-out duration-300 inline-block">
                    Get Started Now
                </a>
                <a href="/listings" class="px-10 py-4 bg-transparent border-2 border-white text-white font-bold rounded-full shadow-xl hover:bg-white hover:text-blue-700 transition ease-in-out duration-300 inline-block dark:hover:bg-gray-800 dark:hover:text-white">
                    Browse Listings
                </a>
            </div>
            <div class="mt-8 text-sm text-gray-200">
                <span class="font-semibold">Trusted by 10,000+ entrepreneurs</span> • <span class="font-semibold">500+ successful acquisitions</span>
            </div>
        </div>
    </div>

    <!-- 🚀 Key Features Section -->
    <div class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-5xl font-bold text-gray-900 dark:text-white">Why Choose Acqios?</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">We've reimagined the business acquisition process to make it transparent, secure, and efficient.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Verified Listings</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Every business listing undergoes thorough verification to ensure authenticity and transparency.</p>
                </div>

                <!-- Feature 2 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Secure Transactions</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Our secure escrow system protects both buyers and sellers throughout the entire acquisition process.</p>
                </div>

                <!-- Feature 3 -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-pink-100 dark:bg-pink-900 rounded-full flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-600 dark:text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Streamlined Process</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">From listing to closing, our platform simplifies each step of the business acquisition journey.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 💼 How It Works Section -->
    <div class="py-20 bg-gray-100 dark:bg-gray-800">
        <div class="max-w-6xl mx-auto px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-5xl font-bold text-gray-900 dark:text-white">How It Works</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">Your journey to buying or selling a business made simple.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="space-y-12">
                    <!-- Step 1 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-12 h-12 rounded-md bg-blue-600 text-white">
                                1
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Create Your Account</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Sign up in minutes with our streamlined verification process.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-12 h-12 rounded-md bg-blue-600 text-white">
                                2
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">List or Browse</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Sellers create detailed listings while buyers explore verified opportunities.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-12 h-12 rounded-md bg-blue-600 text-white">
                                3
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Connect & Negotiate</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Our secure messaging system facilitates confidential discussions and negotiations.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-12 h-12 rounded-md bg-blue-600 text-white">
                                4
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Close the Deal</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Finalize your transaction with our secure escrow service and transfer support.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg overflow-hidden shadow-xl">
                    <img src="/images/deal_closing.jpg" alt="Business acquisition process" class="w-full h-auto object-cover">
                </div>
            </div>
        </div>
    </div>

    <!-- 💬 Testimonials Section -->
    <div class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-5xl font-bold text-gray-900 dark:text-white">Success Stories</h2>
                <p class="mt-4 text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">Here's what entrepreneurs are saying about their experience with Acqios.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 italic mb-4">"I was able to sell my SaaS business in just 45 days at a valuation that exceeded my expectations. The verification process gave buyers confidence in my financials."</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">JS</div>
                        <div class="ml-3">
                            <h4 class="font-bold text-gray-900 dark:text-white">James S.</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Sold e-commerce business</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 italic mb-4">"As a first-time business buyer, I appreciated how Acqios streamlined the acquisition process. Their escrow service made the transaction secure and stress-free."</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">ML</div>
                        <div class="ml-3">
                            <h4 class="font-bold text-gray-900 dark:text-white">Michelle L.</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Acquired digital agency</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 italic mb-4">"The detailed analytics and valuation tools helped me understand my business's true market value. I received multiple qualified offers within weeks of listing."</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">DR</div>
                        <div class="ml-3">
                            <h4 class="font-bold text-gray-900 dark:text-white">David R.</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Sold SaaS startup</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 📊 Stats Section -->
    <div class="py-20 bg-blue-600 dark:bg-blue-900">
        <div class="max-w-6xl mx-auto px-8 text-center">
            <h2 class="text-3xl sm:text-5xl font-bold text-white mb-16">Trusted by Entrepreneurs Worldwide</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Stat 1 -->
                <div>
                    <div class="text-5xl font-bold text-white mb-2">10K+</div>
                    <div class="text-blue-200">Active Users</div>
                </div>

                <!-- Stat 2 -->
                <div>
                    <div class="text-5xl font-bold text-white mb-2">500+</div>
                    <div class="text-blue-200">Successful Exits</div>
                </div>

                <!-- Stat 3 -->
                <div>
                    <div class="text-5xl font-bold text-white mb-2">$120M+</div>
                    <div class="text-blue-200">Transaction Volume</div>
                </div>

                <!-- Stat 4 -->
                <div>
                    <div class="text-5xl font-bold text-white mb-2">45</div>
                    <div class="text-blue-200">Days Avg. Time to Sell</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 📱 CTA Section -->
    <div class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-6xl mx-auto px-8 text-center">
            <h2 class="text-3xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-8">Ready to Make Your Move?</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto mb-10">
                Whether you're looking to sell your business or find your next opportunity, Acqios provides the platform, tools, and support you need to succeed.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('register') }}" class="px-10 py-4 bg-blue-600 text-white font-bold rounded-full shadow-xl hover:bg-blue-700 transition ease-in-out duration-300 text-xl">
                    Get Started for Free
                </a>
                <a href="/pricing" class="px-10 py-4 bg-transparent border-2 border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-500 font-bold rounded-full shadow-xl hover:bg-blue-600 hover:text-white transition ease-in-out duration-300 text-xl dark:hover:bg-blue-700">
                    View Pricing
                </a>
            </div>
        </div>
    </div>



    <!-- 🦶 Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-6xl mx-auto px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-1">
                    <img src="/images/acqios_logo_white.png" alt="Acqios Logo" class="h-10 mb-4">
                    <p class="text-gray-400 mb-6">The trusted marketplace for entrepreneurs to buy and sell businesses.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124-4.09-.193-7.715-2.157-10.141-5.126-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 14-7.503 14-14v-.617c.961-.689 1.8-1.56 2.46-2.548z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/listings" class="text-gray-400 hover:text-white">Browse Businesses</a></li>
                        <li><a href="/listings/create" class="text-gray-400 hover:text-white">Sell Your Business</a></li>
                        <li><a href="/blog" class="text-gray-400 hover:text-white">Blog</a></li>
                        <li><a href="/about" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="/resources/valuation" class="text-gray-400 hover:text-white">Business Valuation</a></li>
                        <li><a href="/resources/due-diligence" class="text-gray-400 hover:text-white">Due Diligence Guide</a></li>
                        <li><a href="/resources/legal" class="text-gray-400 hover:text-white">Legal Resources</a></li>
                        <li><a href="/faq" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="/help" class="text-gray-400 hover:text-white">Help Center</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Stay Updated</h3>
                    <p class="text-gray-400 mb-4">Get the latest business acquisition insights delivered to your inbox.</p>
                    <form action="/newsletter/subscribe" method="POST" class="flex flex-col sm:flex-row gap-2">
                        @csrf
                        <input type="email" name="email" placeholder="Your email address" required class="bg-gray-800 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition">Subscribe</button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">© 2025 Acqios. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="/privacy" class="text-gray-400 hover:text-white text-sm">Privacy Policy</a>
                    <a href="/terms" class="text-gray-400 hover:text-white text-sm">Terms of Service</a>
                    <a href="/cookies" class="text-gray-400 hover:text-white text-sm">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>
</x-guest-layout>
