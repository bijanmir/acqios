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
                    <a href="{{ route('listings.show', $listing->id) }}" class="block transform transition-all hover:scale-[1.02]">
                        <div class="p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-md hover:shadow-lg transition-shadow cursor-pointer border border-gray-200 dark:border-gray-800 relative">
                                <!-- ✅ Verified Badge -->
                                @if($listing->is_verified)
                                    <div class="absolute top-3 right-3 z-10 rounded-full w-12" title="Verified">
                                        <x-verified-icon></x-verified-icon>
                                    </div>
                                @endif

                                <!-- 🖼️ Image Section -->
                                <div class="relative mb-4">
                                    @php
                                        $images = $listing->images ? json_decode($listing->images, true) : [];
                                        $images = is_array($images) ? $images : [];
                                        $firstImage = !empty($images) ? asset(reset($images)) : 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png';
                                @endphp
                                <img src="{{ $firstImage }}" alt="{{ $listing->title }}"
                                     class="w-full h-52 object-cover rounded-xl shadow-md border dark:border-gray-800 transition-all">
                            </div>

                            <!-- 🏷️ Title -->
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-3 truncate flex items-center">
                                {{ $listing->title }}
                            </h2>

                            <!-- 📍 Location & Category -->
                            <div class="flex flex-wrap items-center text-sm text-gray-700 dark:text-gray-300 gap-3 mb-4">
                                <div class="flex items-center">
                                    <span class="text-lg">📍</span>
                                    <span class="ml-1 font-semibold">Location:</span>
                                    <span class="ml-1 truncate">{{ $listing->location ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-lg">🏷️</span>
                                    <span class="ml-1 font-semibold">Category:</span>
                                    <span class="ml-1 truncate">{{ $listing->category ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- 💰 Price & Revenue -->
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300 mb-4">
                                <div class="flex items-center">
                                    <span class="text-lg">💰</span>
                                    <span class="ml-1 font-semibold">Price:</span>
                                    <span class="ml-1 text-green-600 font-semibold dark:text-green-400">
                            {{ $listing->price ? '$' . number_format($listing->price, 2) : 'N/A' }}
                        </span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-lg">📈</span>
                                    <span class="ml-1 font-semibold">Revenue:</span>
                                    <span class="ml-1">
                            {{ $listing->revenue ? '$' . number_format($listing->revenue, 2) : 'N/A' }}
                        </span>
                                </div>
                            </div>

                            <!-- 📝 Short Description -->
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm mb-4">
                                {{ Str::limit($listing->description, 90) }}
                            </p>

                            <!-- 📅 Metadata & CTA -->
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                <span>📅 Created: {{ $listing->created_at->format('M d, Y') }}</span>
                                <span class="text-blue-500 hover:underline dark:text-blue-400 font-semibold">View Details →</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>


        @endif
    </div>
</x-app-layout>

