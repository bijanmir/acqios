<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Your Listings</h1>
            <a
                href="{{ route('listings.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600"
            >
                Create New Listing
            </a>
        </div>

        @if ($listings->isEmpty())
            <div class="flex items-center justify-center h-64 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
                <p class="text-lg text-gray-500 dark:text-gray-400">
                    You don't have any listings yet.
                    <a href="{{ route('listings.create') }}" class="text-blue-500 hover:underline dark:text-blue-400">Create one now!</a>
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($listings as $listing)
                    <a href="{{ route('listings.show', $listing->id) }}" class="text-decoration-none">
                        <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg hover:shadow-xl transition-shadow cursor-pointer">
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

                                <img src="{{ $firstImage }}" alt="{{ $listing->title }}" class="w-full h-48 object-cover rounded">

                            </div>

                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                {{ $listing->title }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                {{ Str::limit($listing->description, 100) }}
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                <span>Created: {{ $listing->created_at->format('M d, Y') }}</span>
                                <span class="text-blue-500 hover:underline dark:text-blue-400">View Details</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>

