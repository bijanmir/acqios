<!-- Contact Modal (Hidden by Default) -->
<div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex justify-center items-center hidden z-50">
    <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-md w-full border border-gray-300 dark:border-gray-700">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Confirm Message</h3>

        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Are you sure you want to message the listing owner? They will receive a notification with your request.
        </p>

        <!-- Buttons -->
        <div class="flex justify-end space-x-3">
            <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg shadow-md hover:bg-gray-400 transition">
                Cancel
            </button>

            <button onclick="closeModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition">
                Message Owner
            </button>

        </div>
    </div>
</div>

<div class="fixed bottom-0 z-10 w-full bg-gray-50 dark:bg-gray-900 dark:border-gray-800 rounded-t-md border md:hidden">
    <!-- Action Buttons -->
    @auth
        <div class="flex m-5 sm:m-0">
            @if(auth()->user()->id === $listing->user_id)
                <a href="{{ route('listings.edit', $listing) }}"
                   class="px-4 py-2 whitespace-nowrap bg-sky-600 text-white rounded-lg shadow-md hover:bg-sky-700 focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition duration-300 text-center sm:w-auto w-full font-bold">
                    Edit Listing
                </a>
            @else
                <button onclick="openModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 text-center sm:w-auto w-full">
                    Message Owner
                </button>
            @endif
        </div>

    @else
        <a href="{{ route('login') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 text-center sm:w-auto w-full">
            Login to Contact
        </a>
    @endauth
</div>

<x-app-layout>
    <x-slot name="header">
        <!-- Header Section: Title + Verified Badge + Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <!-- Title & Verified Badge -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 sm:justify-between w-full">

                <div class="flex flex-col md:flex-row justify-center  items-center space-y-2">
                    <h2 class="text-2xl mx-2 text-center">
                        {{ $listing->title }}

                    </h2>
                    @if($listing->is_verified)
                        <div class="flex items-center bg-gray-100  dark:border-gray-500 dark:bg-gray-800 font-bold border bg-opacity-80 shadow-md dark:text-white px-2 rounded-full py-1 ">
                            <img class="w-7 h-7 " src="/images/icons/icons8-verified-96.png" alt=""><span class="ml-1">Verified</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="hidden md:flex">
                <!-- Action Buttons -->
                @auth
                    <div class="flex m-5 sm:m-0">
                        @if(auth()->user()->id === $listing->user_id)
                            <a href="{{ route('listings.edit', $listing) }}"
                               class="px-4 py-2 whitespace-nowrap bg-sky-600 text-white rounded-lg shadow-md hover:bg-sky-700 focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition duration-300 text-center sm:w-auto w-full font-bold">
                                Edit Listing
                            </a>
                        @else
                            <button onclick="openModal()" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 text-center sm:w-auto w-full">
                                Message Owner
                            </button>
                        @endif
                    </div>

                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 text-center sm:w-auto w-full">
                        Login to Contact
                    </a>
                @endauth
            </div>
        </div>
    </x-slot>




    <!-- Main Content -->
    <div class="md:py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white dark:bg-gray-800 shadow-lg md:rounded-2xl p-3 md:p-8 border border-gray-200 dark:border-gray-700">

            <!-- Image Gallery -->
            @if(!empty($listing->images))
                @php
                    $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                    $images = is_array($images) ? $images : [];
                @endphp
                <div class="mb-8">
                    <div class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory">
                        @foreach($images as $image)
                            @if(is_string($image) && !empty($image))
                                <img src="{{ asset($image) }}" alt="Listing Image"
                                     class="h-96 w-full object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform hover:scale-105 aspect-w-16 aspect-h-9 relative">
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Business Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach (['category' => 'Category', 'location' => 'Location', 'years_in_business' => 'Years in Business'] as $key => $label)
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $listing->$key ?? 'N/A' }}
                        </p>
                    </div>
                @endforeach
            </div>
            <!-- Listing Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach (['price' => 'Price', 'revenue' => 'Revenue', 'profit' => 'Profit'] as $key => $label)
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $listing->$key ? '$' . number_format($listing->$key, 2) : 'N/A' }}
                        </p>
                    </div>
                @endforeach
            </div>



            <!-- Contact Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach (['contact_email' => 'Contact Email', 'phone_number' => 'Phone Number', 'website' => 'Website'] as $key => $label)
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            @if($key === 'website' && $listing->$key)
                                <a href="{{ $listing->$key }}" class="text-blue-600 hover:underline dark:text-blue-400" target="_blank">
                                    {{ $listing->$key }}
                                </a>
                            @else
                                {{ $listing->$key ?? 'N/A' }}
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Business Sections -->
            <div class="mb-8">
                @php
                    $sections = json_decode($listing->sections ?? '[]', true) ?? [];
                @endphp
                @if (!empty($sections))
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Business Sections</h3>

                    @foreach ($sections as $section)
                        <div class="mt-4 p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $section['title'] ?? 'Untitled Section' }}</h4>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $section['description'] ?? 'No description available.' }}</p>
                        </div>
                    @endforeach
                @else
                    <div id="no-sections"></div>
                @endif
            </div>

            <!-- Timestamps -->
            <div class="text-sm text-gray-500 dark:text-gray-400 mt-6 flex justify-between p-2 ">
                <p>📅 Created: {{ $listing->created_at->format('M d, Y') }}</p>
                <p>🕒 Updated: {{ $listing->updated_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('contactModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('contactModal').classList.add('hidden');
        }

        function sendMessage() {
            alert("Your message request has been sent to the listing owner!");
            // Here you can add AJAX request or any other backend logic
        }
    </script>

</x-app-layout>

