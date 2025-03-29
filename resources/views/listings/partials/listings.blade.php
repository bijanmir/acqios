@if ($listings->isEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-10 text-center border border-gray-200 dark:border-gray-700">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No listings found</h3>
        <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
            We couldn't find any listings matching your criteria. Try adjusting your filters or search terms.
        </p>
        <a href="{{ route('listings.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to All Listings
        </a>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($listings as $listing)
            <x-listing-card :listing="$listing" />
        @endforeach
    </div>

    <!-- Pagination (only if it's a paginator instance) -->
    @if (method_exists($listings, 'links'))
        <div class="mt-8">
            {{ $listings->links() }}
        </div>
    @endif
@endif

<script>
    // View toggle functionality (add to your existing scripts if needed)
    document.addEventListener('DOMContentLoaded', () => {
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        const gridViewBtn = document.getElementById('gridView');
        const listViewBtn = document.getElementById('listView');

        if (gridView && listView && gridViewBtn && listViewBtn) {
            // Set initial view based on localStorage
            const savedView = localStorage.getItem('listingsView') || 'grid';

            if (savedView === 'grid') {
                gridView.classList.remove('hidden');
                listView.classList.add('hidden');
            } else {
                gridView.classList.add('hidden');
                listView.classList.remove('hidden');
            }

            // Update view when buttons are clicked
            gridViewBtn.addEventListener('click', () => {
                gridView.classList.remove('hidden');
                listView.classList.add('hidden');
            });

            listViewBtn.addEventListener('click', () => {
                gridView.classList.add('hidden');
                listView.classList.remove('hidden');
            });
        }
    });
</script>
