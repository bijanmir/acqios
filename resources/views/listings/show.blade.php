<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 text-center">
            {{ $listing->title }}
        </h2>
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
            </div>
        </div>
    </div>
</x-app-layout>
