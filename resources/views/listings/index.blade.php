<x-app-layout>
    <x-slot name="header">
        <!-- Glassmorphic Search Bar & Filters -->
        <form id="searchForm" action="{{ route('listings.index') }}" method="GET" class="relative flex flex-col rounded-b-lg bg-white/20 dark:bg-gray-900/20  transition-all duration-300 ">
            <!-- 🔍 Search Input + Icon -->
            <div class="flex flex-row space-x-5">
                <div class="relative flex items-center w-full">
                    <input type="text" name="search" id="searchInput"
                           value="{{ request('search') }}" autocomplete="off"
                           placeholder="Search listings..."
                           class="w-full pl-12 pr-16 py-4 bg-white/30 dark:bg-gray-800/30 text-gray-900 dark:text-white border border-white/40 dark:border-gray-600/50 rounded-full focus:ring-2 focus:ring-blue-500/75 focus:outline-none transition-all shadow-xl placeholder-gray-400 dark:placeholder-gray-500">
                    <!-- Search Icon -->
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 19a8 8 0 100-16 8 8 0 000 16zM21 21l-4.35-4.35"></path>
                    </svg>
                </span>
                </div>

                <!-- 🔘 Buttons: Search & Toggle Filters -->
                <div class="flex items-center space-x-2">
                    <!-- Search Button -->
                   <button type="submit" class="bg-black rounded-full text-white p-3 px-4"><i class="fa fa-magnifying-glass"></i> </button>
                    <!-- Filters Toggle Button -->
                    <button type="button" id="toggleFilters"
                            class="bg-black rounded-full text-white p-3 px-4">
                        <i id="filterIcon" class="fa fa-arrow-down"></i>
                    </button>
                </div>
            </div>


            <!-- ❌ Clear Filters Button (Only Visible if Filters are Applied) -->
            <div class="flex justify-center ">
                @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                    <a href="{{ route('listings.index') }}"
                       class="mt-4 inline-flex items-center px-6 py-3 bg-red-500/80 hover:bg-red-600/90 text-white rounded-full shadow-md transition-all transform hover:scale-105">
                        <span>❌</span>
                        <span class="ml-2">Clear Filters</span>
                    </a>
                @endif
            </div>

            <!-- 🎚️ Filters Section -->
            <div id="filters" class="hidden p-6 my-4 rounded-2xl bg-white/40 dark:bg-gray-900/40 backdrop-blur-2xl shadow-md transition-all duration-300 transform scale-95 opacity-0 border dark:border-gray-700">
                <h2 class="text-center text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Filters</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- 📂 Category -->
                    <select name="category" id="categoryFilter"
                            class="px-4 py-3 border border-white/30 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-200 rounded-full shadow-md focus:ring-2 focus:ring-blue-500 transition-all">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>

                    <!-- 💰 Price Range -->
                    <input type="number" name="min_price" id="minPrice" value="{{ request('min_price') }}" placeholder="Min Price"
                           class="px-4 py-3 border border-white/30 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-200 rounded-full shadow-md focus:ring-2 focus:ring-blue-500 transition-all">
                    <input type="number" name="max_price" id="maxPrice" value="{{ request('max_price') }}" placeholder="Max Price"
                           class="px-4 py-3 border border-white/30 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-200 rounded-full shadow-md focus:ring-2 focus:ring-blue-500 transition-all">

                    <!-- 🔽 Sorting -->
                    <select name="sort" id="sortFilter"
                            class="px-4 py-3 border border-white/30 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-200 rounded-full shadow-md focus:ring-2 focus:ring-blue-500 transition-all">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>
        </form>
    </x-slot>

    <!-- 📦 Listings Container -->
    <div id="listingsContainer" class="container mx-auto py-5 px-5 md:px-0">
        @include('listings.partials.listings')
    </div>

    <!-- 🔽 Scripts -->
    <script>
        // Toggle the filters section with smooth animations
        document.getElementById("toggleFilters").addEventListener("click", function () {
            let filters = document.getElementById("filters");
            let icon = document.getElementById("filterIcon");

            if (filters.classList.contains("hidden")) {
                filters.classList.remove("hidden");
                setTimeout(() => {
                    filters.classList.remove("opacity-0", "scale-95");
                    filters.classList.add("opacity-100", "scale-100");
                }, 10);
                icon.classList.remove("fa-arrow-down");
                icon.classList.add("fa-arrow-up");
            } else {
                filters.classList.add("opacity-0", "scale-95");
                filters.classList.remove("opacity-100", "scale-100");
                setTimeout(() => {
                    filters.classList.add("hidden");
                }, 300);
                icon.classList.remove("fa-arrow-up");
                icon.classList.add("fa-arrow-down");
            }
        });


        // Auto-submit the form when any filter value changes
        document.querySelectorAll("#categoryFilter, #sortFilter, #minPrice, #maxPrice").forEach(filter => {
            filter.addEventListener("change", function () {
                document.getElementById("searchForm").submit();
            });
        });
    </script>
</x-app-layout>
