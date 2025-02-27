<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex justify-center items-center hidden z-50 transition-opacity duration-300">
    <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-2xl max-w-md w-full border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Delete Listing</h3>
            <button onclick="closeDeleteModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $listing->title }}</h4>
                <p class="text-gray-600 dark:text-gray-300 text-sm mt-2 line-clamp-3">
                    {{ $listing->description ?? 'No description provided.' }}
                </p>
            </div>

            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Are you sure you want to delete this listing? This action cannot be undone.
            </p>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <x-button
                text="Cancel"
                color="gray"
                onclick="closeDeleteModal()"
            />
            <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" class="p-0 m-0">
                @csrf
                @method('DELETE')
                <x-button
                    text="Delete"
                    color="red"
                    type="submit"
                />
            </form>
        </div>
    </div>
</div>
