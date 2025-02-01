<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                {{ $listing->title }}
                @if($listing->is_verified)
                    <div class="bg-black w-10">
                        <img src="/images/icon" alt="">
                    </div>
                @endif
            </h2>
            @auth
                @if(auth()->user()->id === $listing->user_id)
                    <a href="{{ route('listings.edit', $listing) }}"
                       class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Edit Listing
                    </a>
                @else
                    <a href="#"
                       class="ml-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                        Message Listing Owner
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="ml-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Login to Contact Owner
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg p-6">

            <!-- Image Gallery with Swipe Support -->
            @if(!empty($listing->images))
                @php
                    $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                    $images = is_array($images) ? $images : [];
                @endphp
                <div class="mb-6">
                    <div class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory">
                        @foreach($images as $image)
                            @if(is_string($image) && !empty($image))
                                <img src="{{ asset($image) }}" alt="Listing Image"
                                     class="h-56 w-auto object-cover rounded-lg shadow-md border dark:border-gray-700 snap-center">
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Listing Details -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach (['price' => 'Price', 'revenue' => 'Revenue', 'profit' => 'Profit'] as $key => $label)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
                        <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-3 rounded-lg shadow-sm">
                            {{ $listing->$key ? '$' . number_format($listing->$key, 2) : 'N/A' }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Business Details -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                @foreach (['category' => 'Category', 'location' => 'Location', 'years_in_business' => 'Years in Business'] as $key => $label)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
                        <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-3 rounded-lg shadow-sm">
                            {{ $listing->$key ?? 'N/A' }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Contact Details -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                @foreach (['contact_email' => 'Contact Email', 'phone_number' => 'Phone Number', 'website' => 'Website'] as $key => $label)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
                        <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-3 rounded-lg shadow-sm">
                            @if($key === 'website' && $listing->$key)
                                <a href="{{ $listing->$key }}" class="text-blue-500 hover:underline" target="_blank">
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
            <div class="mb-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200">Business Sections</h3>
                @php
                    $sections = json_decode($listing->sections ?? '[]', true) ?? [];
                @endphp
                @if (!empty($sections))
                    @foreach ($sections as $section)
                        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $section['title'] ?? 'Untitled Section' }}</h4>
                            <p class="text-gray-600 dark:text-gray-400">{{ $section['description'] ?? 'No description available.' }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500 dark:text-gray-400">No sections available.</p>
                @endif
            </div>

            <!-- Created & Updated Timestamps -->
            <div class="text-sm text-gray-500 dark:text-gray-400 mt-6">
                <p>Created on: {{ $listing->created_at->format('M d, Y') }}</p>
                <p>Last Updated: {{ $listing->updated_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
