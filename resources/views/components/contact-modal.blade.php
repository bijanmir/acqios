<div id="contactModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex justify-center items-center hidden z-50 transition-all duration-300">
    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-2xl max-w-md w-full border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 mx-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Contact Listing Owner</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 rounded-full p-1 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Listing Info -->
        <div class="space-y-5">
            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/30">
                <div class="flex items-start">
                    @if(!empty($listing->images))
                        @php
                            $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                            $firstImage = is_array($images) && !empty($images) ? reset($images) : null;
                        @endphp
                        @if($firstImage)
                            <div class="flex-shrink-0 mr-4">
                                <img src="{{ asset($firstImage) }}" alt="{{ $listing->title }}" class="w-16 h-16 object-cover rounded-lg shadow-sm">
                            </div>
                        @endif
                    @endif
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $listing->title }}</h4>
                        <p class="text-indigo-700 dark:text-indigo-300 text-sm font-medium">{{ $listing->category }}</p>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mt-2 line-clamp-2">
                            {{ $listing->description ?? 'No description provided.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Message Info -->
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                <h5 class="font-medium text-gray-900 dark:text-white flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    What happens next?
                </h5>
                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        The listing owner will receive your contact request
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        They will respond directly to your registered email
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        You'll receive a confirmation when your message is sent
                    </li>
                </ul>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 mt-6">
            <button onclick="closeModal()"
                    class="px-5 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition duration-200 font-medium">
                Cancel
            </button>

            <form action="{{ route('listings.contact', $listing) }}" method="POST" class="p-0 m-0">
                @csrf
                <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Send Message
                </button>
            </form>
        </div>
    </div>
</div>
