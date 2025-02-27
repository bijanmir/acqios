<x-app-layout>
    <x-slot name="header">
        <!-- Glassmorphic Search Bar & Filters -->
        <form id="searchForm" action="{{ route('listings.index') }}" method="GET" class="relative bg-white/20 dark:bg-gray-900/20 rounded-b-lg shadow-xl transition-all duration-300">
            <!-- 🔍 Search Input + Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 p-4">
                <div class="relative flex-grow">
                    <input type="text" name="search" id="searchInput"
                           value="{{ request('search') }}" autocomplete="off"
                           placeholder="Search listings..."
                           class="w-full pl-12 pr-4 py-3 bg-white/30 dark:bg-gray-800/30 text-gray-900 dark:text-white border border-white/40 dark:border-gray-600/50 rounded-full focus:ring-2 focus:ring-blue-500/75 focus:outline-none transition-all shadow-md placeholder-gray-400 dark:placeholder-gray-500"
                           aria-label="Search listings">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19a8 8 0 100-16 8 8 0 000 16zM21 21l-4.35-4.35"></path>
                        </svg>
                    </span>
                </div>
                <div class="flex items-center space-x-2 mt-3 sm:mt-0">
                    <x-button type="submit" text='<i class="fa fa-magnifying-glass"></i>' color="black" additional-classes="px-4" aria-label="Submit search" />
                    <x-button type="button" id="toggleFilters" text='<i id="filterIcon" class="fa fa-arrow-down"></i>' color="black" additional-classes="px-4" aria-label="Toggle filters" />
                </div>
            </div>

            <!-- ❌ Clear Filters Button -->
            @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                <div class="flex justify-center pb-4">
                    <a href="{{ route('listings.index') }}" class="inline-flex items-center space-x-2">
                        <x-button text="Clear Filters" color="red" additional-classes="flex items-center space-x-2">
                            <span slot="prepend">❌</span>
                        </x-button>
                    </a>
                </div>
            @endif

            <!-- 🎚️ Filters Section -->
            <div id="filters" class="hidden p-6 mt-4 rounded-2xl bg-white/40 dark:bg-gray-900/40 backdrop-blur-2xl shadow-lg border border-gray-200 dark:border-gray-700 transition-all duration-300 transform scale-95 opacity-0">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6 text-center">Refine Your Search</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <select name="category" id="categoryFilter"
                            class="w-full px-4 py-3 bg-gray-50/80 dark:bg-gray-800/80 text-gray-900 dark:text-gray-200 border border-white/30 dark:border-gray-600 rounded-full shadow-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="min_price" id="minPrice" value="{{ request('min_price') }}" placeholder="Min Price"
                           class="w-full px-4 py-3 bg-gray-50/80 dark:bg-gray-800/80 text-gray-900 dark:text-gray-200 border border-white/30 dark:border-gray-600 rounded-full shadow-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
                           aria-label="Minimum price">
                    <input type="number" name="max_price" id="maxPrice" value="{{ request('max_price') }}" placeholder="Max Price"
                           class="w-full px-4 py-3 bg-gray-50/80 dark:bg-gray-800/80 text-gray-900 dark:text-gray-200 border border-white/30 dark:border-gray-600 rounded-full shadow-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all"
                           aria-label="Maximum price">
                    <select name="sort" id="sortFilter"
                            class="w-full px-4 py-3 bg-gray-50/80 dark:bg-gray-800/80 text-gray-900 dark:text-gray-200 border border-white/30 dark:border-gray-600 rounded-full shadow-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>
        </form>
    </x-slot>

    <!-- 📦 Listings Container -->
    <div id="listingsContainer" class="container mx-auto py-8 px-4 md:px-0">
        @include('listings.partials.listings')
    </div>

    <!-- 🔽 Scripts -->
    <script>
        // Toggle filters with smooth animation
        const toggleFiltersBtn = document.getElementById("toggleFilters");
        const filters = document.getElementById("filters");
        const filterIcon = document.getElementById("filterIcon");

        toggleFiltersBtn.addEventListener("click", () => {
            if (filters.classList.contains("hidden")) {
                filters.classList.remove("hidden");
                setTimeout(() => {
                    filters.classList.remove("opacity-0", "scale-95");
                    filters.classList.add("opacity-100", "scale-100");
                    filterIcon.classList.replace("fa-arrow-down", "fa-arrow-up");
                }, 10);
            } else {
                filters.classList.add("opacity-0", "scale-95");
                filters.classList.remove("opacity-100", "scale-100");
                setTimeout(() => {
                    filters.classList.add("hidden");
                    filterIcon.classList.replace("fa-arrow-up", "fa-arrow-down");
                }, 300);
            }
        });

        // Debounced search submission
        let searchTimeout;
        const searchInput = document.getElementById("searchInput");
        searchInput.addEventListener("input", () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById("searchForm").submit();
            }, 500); // 500ms debounce
        });

        // Auto-submit on filter change
        document.querySelectorAll("#categoryFilter, #sortFilter, #minPrice, #maxPrice").forEach(filter => {
            filter.addEventListener("change", () => {
                document.getElementById("searchForm").submit();
            });
        });
    </script>
</x-app-layout>
