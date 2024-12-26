<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 text-center">
            {{ $listing->title }}
        </h2>
        @auth
            <div class="dark:text-white">
                <p>You are logged in as {{ auth()->user()->id }}</p>
                <p>Listing Owner ID: {{ $listing->user_id }}</p>

                @if(auth()->user()->id === $listing->user_id)
                    <p>You own this listing!</p>
                @else
                    <p>You do not own this listing.</p>
                @endif
            </div>
        @endauth
    </x-slot>

    <div class="py-8">
        <div class="container mx-auto max-w-3xl">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                    {{ $listing->title }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ $listing->description }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-500">
                    Created on: {{ $listing->created_at->format('M d, Y') }}
                </p>

                <!-- Edit Button -->
                @can('update', $listing)
                    <div class="mt-6">
                        <a href="{{ route('listings.edit', $listing) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Edit Listing
                        </a>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
