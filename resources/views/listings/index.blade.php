<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 text-center">
            Explore Listings
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="container mx-auto">
            @if ($listings->isEmpty())
                <p class="text-center text-gray-500">No listings found. Check back later!</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($listings as $listing)
                        <a href="{{ route('listings.show', $listing->id) }}" class="text-decoration-none">
                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 hover:shadow-lg transition cursor-pointer" style="position: relative;">
                                <!-- Image Section -->
                                <div class="mb-4">
                                    @php
                                        // Decode images safely and ensure it's always an array
                                        $images = $listing->images ? json_decode($listing->images, true) : [];

                                        // Ensure $images is an array (handle cases where json_decode returns null)
                                        $images = is_array($images) ? $images : [];

                                        // Filter out non-existing images
                                        $images = array_filter($images, function ($img) {
                                            return file_exists(public_path(str_replace('/storage/', 'storage/', $img)));
                                        });

                                        // Get first image or use placeholder
                                        $firstImage = !empty($images) ? asset(reset($images)) : 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png';
                                    @endphp

                                    <img src="{{ $firstImage }}" alt="{{ $listing->title }}" class="w-full h-64 object-cover rounded">


                                </div>

                                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                    {{ $listing->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-2">
                                    {{ Str::limit($listing->description, 100) }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-500 mt-4">
                                    Created on: {{ $listing->created_at->format('M d, Y') }}
                                </p>
                                <!-- This pseudo-element makes the whole card clickable -->
                                <style>
                                    .card-link::after {
                                        content: '';
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        bottom: 0;
                                        right: 0;
                                        pointer-events: auto;
                                    }
                                </style>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
