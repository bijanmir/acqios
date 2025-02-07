<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div class="flex flex-col justify-center items-center space-y-2">
                <h2 class="text-2xl mx-2 text-center">
                    {{ isset($listing) ? 'Edit Listing' : 'Create Listing' }}
                </h2>
            </div>

            <!-- Fixed Update Button for Desktop -->
            <div class="hidden md:block">
                <button type="submit" form="listingForm"
                        class="px-4 py-2 whitespace-nowrap bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 text-center sm:w-auto w-full font-bold">
                    {{ isset($listing) ? 'Update Listing' : 'Create Listing' }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="md:py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg md:rounded-2xl p-3 md:p-8 border border-gray-200 dark:border-gray-700">

            <!-- Form Start -->
            <form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="listingForm">
                @csrf
                @if (isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif

                <input type="hidden" name="delete_images" id="delete_images" value="[]">
                <input type="hidden" name="deleted_sections" id="deleted_sections" value="[]">

                <!-- Image Preview Section -->
                @if(isset($listing) && !empty($listing->images))
                    <div class="mb-8">
                        <div id="image-display-carousel" class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory">
                            @foreach(json_decode($listing->images, true) ?? [] as $image)
                                <div class="relative">
                                    <img src="{{ asset($image) }}" alt="Listing Image"
                                         class="h-96 w-96 object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform hover:scale-105">
                                    <button type="button" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full shadow-md delete-image-button" data-image="{{ $image }}">
                                        ✕
                                    </button>
                                </div>
                            @endforeach

                            <!-- Upload New Images (Now aligned with the images) -->
                            <label for="images" class="flex items-center justify-center h-96 w-96 bg-gray-200 dark:bg-gray-700 rounded-xl cursor-pointer upload-image-button border border-dashed border-gray-400 dark:border-gray-600">
                                <svg class="w-10 h-10 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <input type="file" id="images" name="images[]" multiple class="hidden" accept="image/*" onchange="previewImages(event)">
                            </label>
                        </div>
                    </div>
                @endif


                <!-- Upload New Images -->
                <label for="images" class="flex items-center justify-center h-52 w-full bg-gray-200 dark:bg-gray-700 rounded-lg cursor-pointer upload-image-button border border-dashed border-gray-400 dark:border-gray-600">
                    <span class="text-gray-500 dark:text-gray-300">Click to Upload Images</span>
                    <input type="file" id="images" name="images[]" multiple class="hidden" accept="image/*" onchange="previewImages(event)">
                </label>

                <!-- Business Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @foreach (['title' => 'Title', 'category' => 'Category', 'location' => 'Location'] as $key => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                            <input type="text" name="{{ $key }}" id="{{ $key }}"
                                   class="w-full rounded-lg bg-gray-100 dark:bg-gray-700 p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500"
                                   value="{{ old($key, $listing->$key ?? '') }}" required>
                        </div>
                    @endforeach
                </div>

                <!-- Listing Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @foreach (['price' => 'Price', 'revenue' => 'Revenue', 'profit' => 'Profit'] as $key => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                            <input type="number" step="0.01" name="{{ $key }}" id="{{ $key }}"
                                   class="w-full rounded-lg bg-gray-100 dark:bg-gray-700 p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500"
                                   value="{{ old($key, $listing->$key ?? '') }}">
                        </div>
                    @endforeach
                </div>

                <!-- Contact Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @foreach (['contact_email' => 'Contact Email', 'phone_number' => 'Phone Number', 'website' => 'Website'] as $key => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                            <input type="text" name="{{ $key }}" id="{{ $key }}"
                                   class="w-full rounded-lg bg-gray-100 dark:bg-gray-700 p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500"
                                   value="{{ old($key, $listing->$key ?? '') }}">
                        </div>
                    @endforeach
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full rounded-lg bg-gray-100 dark:bg-gray-700 p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500"
                              required>{{ old('description', $listing->description ?? '') }}</textarea>
                </div>

                <!-- Business Sections -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Business Sections</h3>
                    <div id="sections-container">
                        @foreach (json_decode($listing->sections ?? '[]', true) ?? [] as $section)
                            <div class="section-entry bg-gray-50 dark:bg-gray-800 p-4 rounded-lg shadow-md border border-gray-300 dark:border-gray-700 mb-4">
                                <input type="hidden" name="sections[{{ $section['id'] }}][id]" value="{{ $section['id'] }}">
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Title</label>
                                <input type="text" name="sections[{{ $section['id'] }}][title]"
                                       class="w-full rounded-lg bg-gray-100 dark:bg-gray-700 p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500"
                                       value="{{ $section['title'] }}" required>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mt-2">Description</label>
                                <textarea name="sections[{{ $section['id'] }}][description]" rows="2"
                                          class="w-full rounded-lg bg-gray-100 dark:bg-gray-700 p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500"
                                          required>{{ $section['description'] }}</textarea>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addSection()"
                            class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        + Add Section
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sticky "Update Listing" Button for Mobile -->
    <div class="fixed bottom-0 z-10 w-full bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-md p-4 flex justify-center md:hidden">
        <button type="submit" form="listingForm"
                class="px-6 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 text-center w-full md:w-auto font-bold">
            {{ isset($listing) ? 'Update Listing' : 'Create Listing' }}
        </button>
    </div>
</x-app-layout>
