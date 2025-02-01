<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 text-center">
            Explore Listings
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="container mx-auto px-4">
            @if ($listings->isEmpty())
                <p class="text-center text-gray-500 dark:text-gray-400">No listings found. Check back later!</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($listings as $listing)
                        <a href="{{ route('listings.show', $listing->id) }}"
                           class="group block transform transition-all hover:scale-[1.02] rounded-2xl">
                            <div class="relative p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-md hover:shadow-xl transition-shadow border border-gray-200 dark:border-gray-800">

                                <!-- ✅ Verified Badge (Smaller & Better Placement) -->
                                @if($listing->is_verified)
                                    <div class="z-10 absolute top-3 right-3 bg-green-600 text-white text-xs font-medium px-2 py-1 rounded-full shadow flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Verified
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
                                         class="w-full h-52 object-cover rounded-xl transition-transform duration-300 group-hover:scale-105">
                                </div>

                                <!-- 🏷️ Title -->
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 truncate">
                                    {{ $listing->title }}
                                </h3>

                                <!-- 📍 Location & Category -->
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="truncate">{{ $listing->location ?? 'N/A' }}</span>
                                    </div>
                                    <div class="truncate">{{ $listing->category ?? 'N/A' }}</div>
                                </div>

                                <!-- 💰 Price & Revenue -->
                                <div class="grid grid-cols-1 gap-1 text-sm text-gray-700 dark:text-gray-300 mb-3">
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
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                    {{ Str::limit($listing->description, 90) }}
                                </p>

                                <!-- 📅 Metadata & CTA -->
                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                    <span>📅 {{ $listing->created_at->format('M d, Y') }}</span>
                                    <span class="text-blue-600 hover:underline dark:text-blue-400 font-semibold">View Details →</span>
                                </div>

                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
