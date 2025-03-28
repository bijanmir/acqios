<a href="{{ route('listings.show', $listing->id) }}"
   class="group block bg-gray-50 dark:bg-gray-900/70 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 ease-in-out transform hover:scale-105 border border-gray-300/50 dark:border-gray-700/50 overflow-hidden">
    <div class="relative">
        <!-- Verified Badge -->
        @if($listing->is_verified)
            <span class="absolute top-3 right-3 bg-gray-100/80 text-gray-700 text-xs font-medium px-3 py-1 rounded-full shadow-md dark:bg-gray-800/80 dark:text-gray-300 flex items-center">
<img class="w-4 h-4 mr-2" src="https://img.icons8.com/emoji/48/check-mark-emoji.png" alt="check-mark-emoji"/>                Verified
            </span>
        @endif

        <!-- Featured Badge -->
        @if($listing->is_featured ?? false)
            <span class="absolute top-3 left-3 bg-gray-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                ⭐ Featured
            </span>
        @endif

        <!-- Image Section -->
        <div class="relative">
            @php
                $images = $listing->images ? json_decode($listing->images, true) : [];
                $images = is_array($images) ? $images : [];
                $firstImage = !empty($images) ? asset(reset($images)) : 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png';
            @endphp
            <img src="{{ $firstImage }}" alt="{{ $listing->title }}"
                 class="w-full h-56 object-cover rounded-t-3xl transition-transform duration-300 ease-in-out ">
        </div>
    </div>

    <!-- Content -->
    <div class="p-6">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-3 truncate">
            {{ $listing->title }}
        </h2>
        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-4">
            <div class="flex items-center gap-1">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
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
                <span class="font-semibold text-gray-700 dark:text-gray-300">
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
            <span class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-semibold underline underline-offset-2 transition-colors duration-200">View Details →</span>
        </div>
    </div>
</a>
