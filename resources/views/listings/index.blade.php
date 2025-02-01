<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 text-center">
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
                        <a href="{{ route('listings.show', $listing->id) }}" class="block transform transition-all hover:scale-[1.02]">
                            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-md hover:shadow-lg transition-shadow cursor-pointer border border-gray-200 dark:border-gray-800 relative p-6">

                                <!-- ✅ Verified Badge -->
                                @if($listing->is_verified)
                                    <div class="absolute top-3 right-3 bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md flex items-center z-10">
                                        ✅ Verified
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
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2 truncate">
                                    {{ $listing->title }}
                                </h3>

                                <!-- 📍 Location & Category -->
                                <div class="flex flex-wrap items-center text-sm text-gray-700 dark:text-gray-300 gap-3 mb-3">
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
                                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300 mb-3">
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
    </div>
</x-app-layout>
