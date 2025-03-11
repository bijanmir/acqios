<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white text-center">
                {{ __('Dashboard') }}
            </h2>
            <!-- Header with Action Button -->
            <div class="flex flex-col sm:flex-row sm:justify-between items-center">
                <a href="{{ route('listings.create') }}"
                   class="button-main bg-black dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:border-gray-500">
                    <span>Create Listing</span>
                    <span class="invert">➕</span>
                </a>
            </div>
        </div>


    </x-slot>

    <div class="max-w-7xl mx-auto px-5 md:px-0 py-8">
        @if ($listings->isEmpty())
            <div class="text-center bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                <p class="text-gray-600 dark:text-gray-400 text-lg mb-3">
                    You don't have any listings yet.
                </p>
                <a href="{{ route('listings.create') }}"
                   class="inline-block text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium underline underline-offset-4 transition-colors duration-200 ease-in-out">
                    Create one now!
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($listings as $listing)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <x-listing-card :listing="$listing" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
