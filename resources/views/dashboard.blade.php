<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white text-center">
                {{ __('Dashboard') }}
            </h2>
            <!-- Header with Action Button -->
            <div class="flex flex-col sm:flex-row sm:justify-between items-center">
                <a href="{{ route('listings.create') }}"
                   class="button-main">
                    <span>Create Listing</span>
                    <span class="invert">➕</span>
                </a>
            </div>
        </div>


    </x-slot>

    <div class="max-w-7xl mx-auto p-5 md:px-0">

        @if ($listings->isEmpty())
            <div class="flex flex-col items-center justify-center h-64 bg-gray-200/70 dark:bg-gray-800/70 rounded-3xl shadow-2xl  p-6 border border-gray-300/50 dark:border-gray-700/50">
                <p class="text-center text-base md:text-lg text-gray-700 dark:text-gray-200">
                    You don't have any listings yet.
                    <a href="{{ route('listings.create') }}" class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 underline underline-offset-4 transition-colors duration-200">
                        Create one now!
                    </a>
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($listings as $listing)
                    <x-listing-card :listing="$listing" />
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
