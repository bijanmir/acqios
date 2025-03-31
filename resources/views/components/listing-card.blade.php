<a href="{{ route('listings.show', $listing) }}" class="listing-card">
    <div class="listing-image-container">
        @php
            $images = $listing->images ? json_decode($listing->images, true) : [];
            $images = is_array($images) ? $images : [];
            $firstImage = $listing->featured_image ? asset($listing->featured_image) : (isset($images[0]) ? asset($images[0]) : 'https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png');
            $imageCount = count($images);
        @endphp

        <img src="{{ $firstImage }}" alt="{{ $listing->title }}" class="listing-image">

        @if($imageCount > 1)
            <div class="listing-image-count">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ $imageCount }}
            </div>
        @endif
    </div>

    <div class="listing-tags-container">
        @if($listing->category)
            <span class="listing-tag listing-tag-category">{{ $listing->category }}</span>
        @endif

        @if($listing->price)
            <span class="listing-tag listing-tag-price">${{ number_format($listing->price) }}</span>
        @endif
    </div>

    <div class="listing-badges-container">
        @if($listing->is_verified)
            <span class="listing-tag listing-tag-verified">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Verified
            </span>
        @endif

        @if($listing->is_featured)
            <span class="listing-tag bg-yellow-100 text-yellow-800 dark:bg-yellow-900/80 dark:text-yellow-300">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                Featured
            </span>
        @endif
    </div>

    <div class="listing-content">
        <div class="space-y-3">
            <h2 class="listing-title">{{ $listing->title }}</h2>

            @if($listing->location)
                <div class="listing-location">
                    <svg class="w-4 h-4 flex-shrink-0 mr-1.5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="truncate">{{ $listing->location }}</span>
                </div>
            @endif

            <p class="listing-description">{{ Str::limit($listing->description, 150) }}</p>

            @if($listing->revenue || $listing->profit)
                <div class="listing-stats">
                    @if($listing->revenue)
                        <div class="listing-stat">
                            <div class="listing-stat-icon listing-stat-revenue">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Revenue</div>
                                <div class="font-medium text-gray-900 dark:text-white">${{ number_format($listing->revenue) }}</div>
                            </div>
                        </div>
                    @endif

                    @if($listing->profit)
                        <div class="listing-stat">
                            <div class="listing-stat-icon listing-stat-profit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Profit</div>
                                <div class="font-medium text-gray-900 dark:text-white">${{ number_format($listing->profit) }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="listing-footer">
            <div class="listing-meta">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $listing->created_at->diffForHumans() }}
            </div>

            <div class="listing-meta">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                {{ $listing->views ?? 0 }} {{ Str::plural('view', $listing->views ?? 0) }}
            </div>

            <span class="listing-view-details">
                View Details
                <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </span>
        </div>
    </div>
</a>
