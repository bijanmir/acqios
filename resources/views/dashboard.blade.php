<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Your Listings</h1>

        @if ($listings->isEmpty())
            <div class="flex items-center justify-center h-64 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
                <p class="text-lg text-gray-500 dark:text-gray-400">
                    You don't have any listings yet.
                    <a href="#" class="text-blue-500 hover:underline dark:text-blue-400">Create one now!</a>
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($listings as $listing)
                    <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            {{ $listing->title }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            {{ Str::limit($listing->description, 100) }}
                        </p>
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                            <span>Created: {{ $listing->created_at->format('M d, Y') }}</span>
                            <a href="#" class="text-blue-500 hover:underline dark:text-blue-400">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
