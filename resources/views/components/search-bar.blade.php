@props(['categories' => []])

<div class="bg-gradient-to-r from-indigo-50/90 to-blue-50/90 dark:from-gray-800/50 dark:to-gray-700/50 rounded-2xl p-5 backdrop-blur-xl shadow-lg border border-white/20 dark:border-gray-700/30">
    <form id="searchForm" action="{{ route('listings.index') }}" method="GET" class="transition-all duration-300">
        <!-- Search Input + Buttons -->
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-grow w-full">
                <input type="text" name="search" id="searchInput"
                       value="{{ request('search') }}" autocomplete="off"
                       placeholder="Search for businesses, opportunities..."
                       class="w-full pl-12 pr-4 py-3 bg-white/70 dark:bg-gray-800/70 text-gray-900 dark:text-white border border-white/40 dark:border-gray-600/50 rounded-xl focus:ring-2 focus:ring-indigo-500/75 focus:outline-none transition-all shadow-sm placeholder-gray-500 dark:placeholder-gray-400">
                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-indigo-500 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19a8 8 0 100-16 8 8 0 000 16zM21 21l-4.35-4.35"></path>
                            </svg>
                        </span>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg flex items-center justify-center shadow-sm transition-colors w-full sm:w-auto">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>

                <button type="button" id="toggleFilters" class="px-4 py-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 font-medium rounded-lg flex items-center justify-center shadow-sm border border-gray-200 dark:border-gray-600 transition-colors w-full sm:w-auto">
                    <span>Filters</span>
                    <svg id="filterIcon" class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Active Filters Display -->
        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active filters:</span>

                @if(request('search'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 dark:bg-indigo-900/40 text-indigo-800 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800/60">
                        <span>Search: "{{ request('search') }}"</span>
                        <a href="{{ request()->url() }}?{{ http_build_query(request()->except(['search', 'page'])) }}" class="ml-1.5 text-indigo-700 dark:text-indigo-400 hover:text-indigo-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                @endif

                @if(request('category'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800/60">
                        <span>Category: {{ ucfirst(request('category')) }}</span>
                        <a href="{{ request()->url() }}?{{ http_build_query(request()->except(['category', 'page'])) }}" class="ml-1.5 text-blue-700 dark:text-blue-400 hover:text-blue-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                @endif

                @if(request('min_price') || request('max_price'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-800/60">
                                <span>Price:
                                    @if(request('min_price') && request('max_price'))
                                        ${{ number_format(request('min_price')) }} - ${{ number_format(request('max_price')) }}
                                    @elseif(request('min_price'))
                                        ${{ number_format(request('min_price')) }}+
                                    @else
                                        Up to ${{ number_format(request('max_price')) }}
                                    @endif
                                </span>
                        <a href="{{ request()->url() }}?{{ http_build_query(request()->except(['min_price', 'max_price', 'page'])) }}" class="ml-1.5 text-green-700 dark:text-green-400 hover:text-green-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                @endif

                @if(request('sort'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-800/60">
                                <span>Sort:
                                    @switch(request('sort'))
                                        @case('latest')
                                            Newest
                                            @break
                                        @case('price_low')
                                            Price: Low to High
                                            @break
                                        @case('price_high')
                                            Price: High to Low
                                            @break
                                    @endswitch
                                </span>
                        <a href="{{ request()->url() }}?{{ http_build_query(request()->except(['sort', 'page'])) }}" class="ml-1.5 text-purple-700 dark:text-purple-400 hover:text-purple-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                @endif

                <a href="{{ route('listings.index') }}" class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-800/60 transition-colors">
                    <span>Clear All</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
        @endif

        <!-- Advanced Filters Section -->
        <div id="filters" class="hidden mt-4 p-6 rounded-xl bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl shadow-md border border-gray-200 dark:border-gray-700 transition-all duration-300 transform scale-95 opacity-0">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Refine Your Search</h2>
                <button type="button" id="applyFilters" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                    Apply Filters
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Category Filter -->
                <div class="space-y-2">
                    <label for="categoryFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                    <select name="category" id="categoryFilter"
                            class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Min Price Filter -->
                <div class="space-y-2">
                    <label for="minPrice" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Minimum Price</label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="min_price" id="minPrice" value="{{ request('min_price') }}" placeholder="0"
                               class="w-full pl-7 pr-3 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                    </div>
                </div>

                <!-- Max Price Filter -->
                <div class="space-y-2">
                    <label for="maxPrice" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Maximum Price</label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="max_price" id="maxPrice" value="{{ request('max_price') }}" placeholder="Any"
                               class="w-full pl-7 pr-3 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                    </div>
                </div>

                <!-- Sort Filter -->
                <div class="space-y-2">
                    <label for="sortFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort By</label>
                    <select name="sort" id="sortFilter"
                            class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Most Viewed</option>
                    </select>
                </div>
            </div>

            <!-- Additional Filters (Optional) -->
            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Additional Filters</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="verified" value="1" {{ request('verified') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Verified Only</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="checkbox" name="with_images" value="1" {{ request('with_images') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">With Images Only</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="checkbox" name="has_website" value="1" {{ request('has_website') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Has Website</span>
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>
