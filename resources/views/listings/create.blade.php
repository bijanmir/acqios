<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Listing') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6">
        <form action="{{ route('listings.store') }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title') }}"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200"
                    required
                />
                @error('title')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200"
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('dashboard') }}" class="bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded shadow hover:bg-gray-400 dark:hover:bg-gray-700">
                    Cancel
                </a>
                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                    Create Listing
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
