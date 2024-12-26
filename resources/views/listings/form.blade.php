<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 text-center">
            {{ isset($listing) ? 'Edit Listing' : 'Create Listing' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="container mx-auto max-w-2xl bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ $action }}">
                @csrf
                @if (isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-300"
                           value="{{ old('title', $listing->title ?? '') }}" required>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-300"
                              required>{{ old('description', $listing->description ?? '') }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        {{ isset($listing) ? 'Update Listing' : 'Create Listing' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
