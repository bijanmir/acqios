<x-app-layout>
    <x-slot name="header">
        <!-- Header Section: Title + Verified Badge + Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <!-- Title & Verified Badge -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 sm:justify-between w-full">

                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 leading-tight text-center">
                    {{ $listing->title }}
                </h2>

                @if($listing->is_verified)
                    <span class=" flex items-center bg-green-600 w-fit mx-auto px-4 py-2 my-2 rounded-full text-white shadow-md">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Verified
                    </span>
                @endif
            </div>

        </div>
    </x-slot>




    <!-- Main Content -->
    <div class="py-6 md:py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-gray-200 dark:border-gray-700">

            <!-- Image Gallery -->
            @if(!empty($listing->images))
                @php
                    $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                    $images = is_array($images) ? $images : [];
                @endphp
                <div class="mb-8">
                    <div class="mb-5 flex justify-end">
                        <!-- Action Buttons -->
                        @auth
                            @if(auth()->user()->id === $listing->user_id)
                                <a href="{{ route('listings.edit', $listing) }}"
                                   class="px-4 py-2 w-fit bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 text-center sm:w-auto w-full">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            @else
                                <a href="#" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 text-center sm:w-auto w-full">
                                    Message Owner
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="px-4 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 text-center sm:w-auto w-full">
                                Login to Contact
                            </a>
                        @endauth
                    </div>
                    <div class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory">
                        @foreach($images as $image)
                            @if(is_string($image) && !empty($image))
                                <img src="{{ asset($image) }}" alt="Listing Image"
                                     class="h-64 w-full object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform hover:scale-105 aspect-w-16 aspect-h-9 relative">
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

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
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Business Sections</h3>
                @php
                    $sections = json_decode($listing->sections ?? '[]', true) ?? [];
                @endphp
                @if (!empty($sections))
                    @foreach ($sections as $section)
                        <div class="mt-4 p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $section['title'] ?? 'Untitled Section' }}</h4>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $section['description'] ?? 'No description available.' }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 dark:text-gray-400">No sections available.</p>
                @endif
            </div>

            <!-- Timestamps -->
            <div class="text-sm text-gray-500 dark:text-gray-400 mt-6 flex justify-between">
                <p>📅 Created: {{ $listing->created_at->format('M d, Y') }}</p>
                <p>🕒 Updated: {{ $listing->updated_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
