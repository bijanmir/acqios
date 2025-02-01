<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Your Listings</h1>
            <a href="{{ route('listings.create') }}" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-lg transition duration-300 ease-in-out">
                Create New Listing
            </a>
        </div>

        @if ($listings->isEmpty())
            <div class="flex flex-col items-center justify-center h-64 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-lg">
                <p class="text-center text-lg text-gray-600 dark:text-gray-300">
                    You don't have any listings yet.
                    <a href="{{ route('listings.create') }}" class="text-blue-600 hover:underline dark:text-blue-400">
                        Create one now!
                    </a>
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($listings as $listing)
                    <a href="{{ route('listings.show', $listing->id) }}"
                       class="group block bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out">
                        <div class="relative overflow-hidden rounded-2xl">
                            <!-- Verified Badge -->
                            @if($listing->is_verified)
                                <span class="absolute top-3 right-3 z-10 flex items-center bg-gray-100 text-gray-700 text-xs font-medium px-2 py-1 rounded-full shadow-sm dark:bg-gray-800 dark:text-gray-300">
                                    <img src="/images/icons/icons8-verified-96.png" alt="Verified" class="w-4 h-4 mr-1">
                                    Verified
                                </span>
                            @endif

                            <!-- Featured Badge -->
                            @if($listing->is_featured ?? false)
                                <span class="absolute top-3 left-3 bg-yellow-400 text-white text-xs font-semibold px-2 py-1 rounded-full shadow">
                                    ⭐ Featured
                                </span>
                            @endif

                            <!-- Image Section -->
                            <div class="relative mb-4">
                                @php
                                    $images = $listing->images ? json_decode($listing->images, true) : [];
                                    $images = is_array($images) ? $images : [];
                                    $firstImage = !empty($images) ? asset(reset($images)) : 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png';
                                @endphp
                                <img src="{{ $firstImage }}" alt="{{ $listing->title }}"
                                     class="w-full h-52 object-cover rounded-t-2xl transition-transform duration-300 ease-in-out group-hover:scale-105">
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2 truncate">
                                    {{ $listing->title }}
                                </h2>

                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="truncate">{{ $listing->location ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="truncate">{{ $listing->category ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <!-- Price & Revenue -->
                                <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                    <div class="flex items-center">
                                        <span class="mr-1 text-lg">💰</span>
                                        <span class="font-semibold text-green-600 dark:text-green-400">
                                            {{ $listing->price ? '$' . number_format($listing->price, 2) : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="mr-1 text-lg">📈</span>
                                        <span class="text-gray-600 dark:text-gray-400">
                                            {{ $listing->revenue ? '$' . number_format($listing->revenue, 2) : 'N/A' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-3">
                                    {{ Str::limit($listing->description, 150) }}
                                </p>

                                <div class="mt-4 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                    <span>📅 {{ $listing->created_at->format('M d, Y') }}</span>
                                    <span class="text-blue-600 hover:underline dark:text-blue-400 font-semibold">View Details →</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
