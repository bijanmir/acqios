<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                {{ $listing->title }}
            </h2>
            @auth
                @if(auth()->user()->id === $listing->user_id)
                    <a href="{{ route('listings.edit', $listing) }}"
                       class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Edit Listing
                    </a>
                @else
                    <a href="#"
                       class="ml-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                        Message Listing Owner
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="ml-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Login to Contact Owner
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg p-6">
            <!-- Image Gallery -->
            @if(!empty($listing->images))
                @php
                    $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                    $images = is_array($images) ? $images : [];
                @endphp
                <div class="mb-6">
                    <div class="flex overflow-x-auto space-x-4 pb-4">
                        @foreach($images as $image)
                            @if(is_string($image) && !empty($image))
                                <img src="{{ asset($image) }}" alt="Listing Image"
                                     class="h-52 w-52 object-cover rounded-lg shadow-md border dark:border-gray-700">
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Listing Details -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                    <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-2 rounded-md">
                        {{ $listing->price ? '$' . number_format($listing->price, 2) : 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Revenue</label>
                    <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-2 rounded-md">
                        {{ $listing->revenue ? '$' . number_format($listing->revenue, 2) : 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profit</label>
                    <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-2 rounded-md">
                        {{ $listing->profit ? '$' . number_format($listing->profit, 2) : 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Business Details -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                    <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-2 rounded-md">
                        {{ $listing->category ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                    <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-2 rounded-md">
                        {{ $listing->location ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Years in Business</label>
                    <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-2 rounded-md">
                        {{ $listing->years_in_business ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contact Email</label>
                    <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-2 rounded-md">
                        {{ $listing->contact_email ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                    <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-2 rounded-md">
                        {{ $listing->phone_number ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Website</label>
                    <p class="bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 p-2 rounded-md">
                        @if($listing->website)
                            <a href="{{ $listing->website }}" class="text-blue-500 hover:underline" target="_blank">
                                {{ $listing->website }}
                            </a>
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>

            <!-- Business Sections -->
            <div class="mb-4 mt-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Business Sections</label>
                @php
                    $sections = json_decode($listing->sections ?? '[]', true) ?? [];
                @endphp
                @if (!empty($sections))
                    @foreach ($sections as $section)
                        <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-300 rounded-md">
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
