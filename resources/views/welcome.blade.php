<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 text-center">
            Explore Listings
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="container mx-auto">
            @if ($listings->isEmpty())
                <p class="text-center text-gray-500">No listings found. Check back later!</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($listings as $listing)
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 hover:shadow-lg transition">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                {{ $listing->title }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">
                                {{ $listing->description }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-4">
                                Created on: {{ $listing->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <footer class="py-4 bg-gray-100 dark:bg-gray-800 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-300">
            &copy; {{ date('Y') }} Acqios. All rights reserved.
        </p>
    </footer>
</x-app-layout>
