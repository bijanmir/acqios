<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                {{ $listing->title }}
            </h2>
            @auth
                @if(auth()->user()->id === $listing->user_id)
                    <a href="{{ route('listings.edit', $listing) }}"
                       class="ml-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Edit Listing
                    </a>
                @else
                    <a href="#"
                       class="ml-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Message Listing Owner
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="ml-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Login to Contact Owner
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <!-- Scrollable Image Section -->
            @if(!empty($listing->images))
                @php
                    // Decode images if necessary
                    $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                    $images = is_array($images) ? $images : []; // Ensure it's an array
                @endphp

                <div class="mb-6">
                    <div class="flex overflow-x-auto space-x-4 pb-4">
                        @foreach($images as $image)
                            @if(is_string($image) && !empty($image))
                                <img src="{{ asset($image) }}" alt="Listing Image" class="h-52 w-52 object-cover rounded-lg">
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif


            <!-- Listing Details -->
            <div class="mt-4">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                    {{ $listing->title }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ $listing->description }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-500">
                    Created on: {{ $listing->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
