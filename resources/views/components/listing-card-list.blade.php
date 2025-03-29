<a href="{{ route('listings.show', $listing->id) }}"
   class="group block bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition-all duration-300 border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="flex flex-col sm:flex-row">
        <!-- Image Section -->
        <div class="relative sm:w-48 lg:w-64">
            @php
                $images = $listing->images ? json_decode($listing->images, true) : [];
                $images = is_array($images) ? $images : [];
                $firstImage = !empty($images) ? asset(reset($images)) : 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png';
            @endphp

            <div class="h-48 sm:h-full overflow-hidden">
                <img src="{{ $firstImage }}" alt="{{ $listing->title }}"
                     class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
            </div>

            <!-- Price Badge -->
            @if($listing->price)
                <div class="absolute bottom-3 left-3 inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/70 dark:text-green-300 shadow-sm">
                    ${{ number_format($listing->price) }}
                </div>
            @endif
        </div>

        <!-- Content Section -->
        <div class="flex-1 p-5 flex flex-col">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2">
                <!-- Title and Category -->
                <div class="mb-2 sm:mb-0">
                    <div class="flex items-center space-x-2 mb-1">
                        @if($listing->is_verified)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/70 dark:text-blue-300">
                                <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Verified
                            </span>
                        @endif

                        @if($listing->is_featured ?? false)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/70 dark:text-amber-300">
                                <svg class="w-3 h-3 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Featured
                            </span>
                        @endif

                        @if($listing->category)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/70 dark:text-indigo-300">
                                {{ ucfirst($listing->category) }}
                            </span>
                        @endif
                    </div>

                    <h2 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $listing->title }}
                    </h2>
                </div>

                <!-- Created Date -->
                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $listing->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <!-- Location -->
            @if($listing->location)
                <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm mb-2">
                    <svg class="w-4 h-4 flex-shrink-0 mr-1.5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    <span class="truncate">{{ $listing->location }}</span>
                </div>
            @endif

            <!-- Description -->
            <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 mb-3 flex-grow">
                {{ $listing->description ? Str::limit($listing->description, 150) : 'No description available.' }}
            </p>

            <!-- Stats Row -->
            <div class="flex flex-wrap justify-between mt-auto pt-3 border-t border-gray-100 dark:border-gray-700">
                <!-- Revenue -->
                @if($listing->revenue)
                    <div class="flex items-center text-sm mr-4 mb-2 sm:mb-0">
                        <div class="mr-1.5 flex-shrink-0 w-5 h-5 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300"><span class="font-medium">Revenue:</span> ${{ number_format($listing->revenue) }}</span>
                    </div>
                @endif

                <!-- Profit -->
                @if($listing->profit)
                    <div class="flex items-center text-sm mr-4 mb-2 sm:mb-0">
                        <div class="mr-1.5 flex-shrink-0 w-5 h-5 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300"><span class="font-medium">Profit:</span> ${{ number_format($listing->profit) }}</span>
                    </div>
                @endif

                <!-- Views -->
                <div class="flex items-center text-sm mr-4 mb-2 sm:mb-0">
                    <div class="mr-1.5 flex-shrink-0 w-5 h-5 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <span class="text-gray-600 dark:text-gray-400">{{ $listing->views ?? 0 }} views</span>
                </div>

                <!-- View Details -->
                <div class="ml-auto">
                    <span class="inline-flex items-center text-indigo-600 dark:text-indigo-400 font-medium group-hover:text-indigo-800 dark:group-hover:text-indigo-300 transition-colors">
                        View Details
                        <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</a>
