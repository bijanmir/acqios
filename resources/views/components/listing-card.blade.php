<a href="{{ route('listings.show', $listing->id) }}"
   class="group block bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-xl transition-all duration-300 ease-in-out transform hover:-translate-y-1 border border-gray-200 dark:border-gray-700 overflow-hidden h-full">
    <!-- Image Section -->
    <div class="relative">
        @php
            $images = $listing->images ? json_decode($listing->images, true) : [];
            $images = is_array($images) ? $images : [];
            $firstImage = !empty($images) ? asset(reset($images)) : 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png';
        @endphp

        <div class="relative h-56 overflow-hidden">
            <img src="{{ $firstImage }}" alt="{{ $listing->title }}"
                 class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">

            <!-- Image Count Badge (if multiple images) -->
            @if(count($images) > 1)
                <div class="absolute bottom-3 right-3 bg-black/60 text-white text-xs font-medium px-2 py-1 rounded-md backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ count($images) }}
                </div>
            @endif
        </div>

        <!-- Category & Price Tag -->
        <div class="absolute top-3 left-3 flex flex-col gap-2">
            @if($listing->category)
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/70 dark:text-indigo-300">
                    {{ ucfirst($listing->category) }}
                </span>
            @endif

            @if($listing->price)
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/70 dark:text-green-300">
                    ${{ number_format($listing->price) }}
                </span>
            @endif
        </div>

        <!-- Badges -->
        <div class="absolute top-3 right-3 flex flex-col gap-2">
            @if($listing->is_verified)
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/70 dark:text-blue-300">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Verified
                </span>
            @endif

            @if($listing->is_featured ?? false)
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/70 dark:text-amber-300">
                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Featured
                </span>
            @endif
        </div>
    </div>

    <!-- Content -->
    <div class="p-5">
        <div class="space-y-3">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                {{ $listing->title }}
            </h2>

            <!-- Location -->
            @if($listing->location)
                <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm">
                    <svg class="w-4 h-4 flex-shrink-0 mr-1.5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    <span class="truncate">{{ $listing->location }}</span>
                </div>
            @endif

            <!-- Description -->
            <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2">
                {{ Str::limit($listing->description, 120) }}
            </p>

            <!-- Business Stats -->
            <div class="pt-2 grid grid-cols-2 gap-4 text-sm border-t border-gray-100 dark:border-gray-700">
                @if($listing->revenue)
                    <div class="flex items-center">
                        <div class="mr-2 flex-shrink-0 w-7 h-7 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Revenue</div>
                            <div class="font-medium text-gray-900 dark:text-white">${{ number_format($listing->revenue) }}</div>
                        </div>
                    </div>
                @endif

                @if($listing->profit)
                    <div class="flex items-center">
                        <div class="mr-2 flex-shrink-0 w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Profit</div>
                            <div class="font-medium text-gray-900 dark:text-white">${{ number_format($listing->profit) }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer with Stats -->
        <div class="mt-4 pt-3 flex justify-between items-center text-xs border-t border-gray-100 dark:border-gray-700">
            <div class="flex items-center text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ $listing->created_at->diffForHumans() }}
            </div>

            <div class="flex items-center text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                {{ $listing->views ?? 0 }} views
            </div>

            <span class="inline-flex items-center text-indigo-600 dark:text-indigo-400 font-medium group-hover:text-indigo-800 dark:group-hover:text-indigo-300 transition-colors">
                View Details
                <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </div>
    </div>
</a>
