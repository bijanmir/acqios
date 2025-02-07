@if ($listings->isEmpty())
    <p class="text-center text-gray-500">No listings found. Try different filters.</p>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($listings as $listing)
            <a href="{{ route('listings.show', $listing->id) }}" class="group block transform transition-all hover:scale-[1.02] rounded-3xl overflow-hidden border shadow-xl">
                <div class="relative p-6 bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-lg hover:shadow-2xl border border-gray-200/50 dark:border-gray-800/50 flex flex-col justify-between h-full backdrop-blur-md">

                    <!-- Verified Badge -->
                    @if($listing->is_verified)
                        <span class="absolute top-4 right-4  bg-gray-50 text-black border shadow-md dark:text-white text-xs font-medium px-2 py-1 rounded-full z-10">
                            ✅ Verified
                        </span>
                    @endif

                    <!-- Image -->
                    @php
                        $images = $listing->images ? json_decode($listing->images, true) : [];
                        $firstImage = !empty($images) ? asset(reset($images)) : asset('path/to/default/image.png');
                    @endphp
                    <img src="{{ $firstImage }}" alt="{{ $listing->title }}" class="w-full h-48 object-cover rounded-2xl mb-4">

                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ $listing->title }}
                    </h3>

                    <!-- Location & Category -->
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                        {{ $listing->location ?? 'N/A' }} | {{ $listing->category ?? 'N/A' }}
                    </div>

                    <!-- Price & Revenue -->
                    <div class="flex justify-between items-center text-sm text-gray-700 dark:text-gray-300 mb-2">
                        <div class="flex items-center">
                            <span class="text-lg">💰</span>
                            <span class="ml-1 font-semibold">Price:</span>
                            <span class="ml-1 text-green-600 font-semibold dark:text-green-400">
                                {{ $listing->price ? '$' . number_format($listing->price, 2) : 'N/A' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center text-sm text-gray-700 dark:text-gray-300">
                        <div class="flex items-center">
                            <span class="text-lg">📈</span>
                            <span class="ml-1 font-semibold">Revenue:</span>
                            <span class="ml-1">
                                {{ $listing->revenue ? '$' . number_format($listing->revenue, 2) : 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <!-- Date -->
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">📅 {{ $listing->created_at->format('M d, Y') }}</p>
                </div>
            </a>
        @endforeach
    </div>
@endif
