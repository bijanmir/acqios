<x-app-layout>
    <x-slot name="header">
        <x-search-bar :categories="$categories" />
    </x-slot>

    <!-- Listings Container -->
    <div class="container mx-auto py-8 px-4 lg:px-0">
        <!-- Results Count & Sort Toggle (Mobile) -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 sm:mb-0">
                @if(isset($listingsCount))
                    {{ $listingsCount }} {{ Str::plural('Result', $listingsCount) }} Found
                @else
                    Browse Listings
                @endif
            </h2>

            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-600 dark:text-gray-400 hidden sm:inline">View as:</span>
                <div class="flex bg-gray-100 dark:bg-gray-800 rounded-lg p-1 border border-gray-200 dark:border-gray-700">
                    <button type="button" id="gridView" class="px-3 py-1 rounded bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button type="button" id="listView" class="px-3 py-1 rounded text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Listings Content -->
        <div id="listingsContent">
            @include('listings.partials.listings')
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="fixed bottom-6 right-6 p-3 rounded-full bg-indigo-600 text-white shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 z-10">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <!-- Scripts -->
    <script>
        // Toggle filters with smooth animation
        const toggleFiltersBtn = document.getElementById("toggleFilters");
        const filters = document.getElementById("filters");
        const filterIcon = document.getElementById("filterIcon");
        const applyFiltersBtn = document.getElementById("applyFilters");

        toggleFiltersBtn.addEventListener("click", () => {
            if (filters.classList.contains("hidden")) {
                filters.classList.remove("hidden");
                setTimeout(() => {
                    filters.classList.remove("opacity-0", "scale-95");
                    filters.classList.add("opacity-100", "scale-100");
                    filterIcon.classList.add("rotate-180");
                }, 10);
            } else {
                filters.classList.add("opacity-0", "scale-95");
                filters.classList.remove("opacity-100", "scale-100");
                filterIcon.classList.remove("rotate-180");
                setTimeout(() => {
                    filters.classList.add("hidden");
                }, 300);
            }
        });

        // Apply filters button
        applyFiltersBtn && applyFiltersBtn.addEventListener("click", () => {
            document.getElementById("searchForm").submit();
        });

        // View toggle (grid/list)
        const gridViewBtn = document.getElementById('gridView');
        const listViewBtn = document.getElementById('listView');
        const listingsContent = document.getElementById('listingsContent');

        if (gridViewBtn && listViewBtn) {
            gridViewBtn.addEventListener('click', () => {
                gridViewBtn.classList.add('bg-white', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200', 'shadow-sm');
                gridViewBtn.classList.remove('text-gray-600', 'dark:text-gray-400', 'hover:bg-gray-200', 'dark:hover:bg-gray-600');

                listViewBtn.classList.remove('bg-white', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200', 'shadow-sm');
                listViewBtn.classList.add('text-gray-600', 'dark:text-gray-400', 'hover:bg-gray-200', 'dark:hover:bg-gray-600');

                // Save preference in localStorage
                localStorage.setItem('listingsView', 'grid');

                // Apply grid view classes (assumes you have relevant CSS)
                if (listingsContent) {
                    listingsContent.classList.remove('listings-list-view');
                    listingsContent.classList.add('listings-grid-view');
                }
            });

            listViewBtn.addEventListener('click', () => {
                listViewBtn.classList.add('bg-white', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200', 'shadow-sm');
                listViewBtn.classList.remove('text-gray-600', 'dark:text-gray-400', 'hover:bg-gray-200', 'dark:hover:bg-gray-600');

                gridViewBtn.classList.remove('bg-white', 'dark:bg-gray-700', 'text-gray-800', 'dark:text-gray-200', 'shadow-sm');
                gridViewBtn.classList.add('text-gray-600', 'dark:text-gray-400', 'hover:bg-gray-200', 'dark:hover:bg-gray-600');

                // Save preference in localStorage
                localStorage.setItem('listingsView', 'list');

                // Apply list view classes (assumes you have relevant CSS)
                if (listingsContent) {
                    listingsContent.classList.remove('listings-grid-view');
                    listingsContent.classList.add('listings-list-view');
                }
            });

            // Load saved preference
            document.addEventListener('DOMContentLoaded', () => {
                const savedView = localStorage.getItem('listingsView');
                if (savedView === 'list') {
                    listViewBtn.click();
                } else {
                    gridViewBtn.click();
                }
            });
        }

        // Scroll to top button
        const scrollToTopBtn = document.getElementById('scrollToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.remove('opacity-0', 'invisible');
                scrollToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                scrollToTopBtn.classList.add('opacity-0', 'invisible');
                scrollToTopBtn.classList.remove('opacity-100', 'visible');
            }
        });

        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</x-app-layout>
