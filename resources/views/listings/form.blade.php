<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 w-full">
                <div class="flex flex-col md:flex-row justify-center items-center space-y-2 md:space-y-0 md:space-x-4">
                    <h2 class="text-2xl text-center font-bold text-gray-900 dark:text-white">
                        {{ isset($listing) ? 'Edit Listing' : 'Create Listing' }}
                    </h2>
                    @if(isset($listing))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                            ID: {{ $listing->id }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                <x-button
                    text="{{ isset($listing) ? 'Update Listing' : 'Save Listing' }}"
                    type="submit"
                    form="listingForm"
                    color="green"
                    icon="fa-save"
                />
                @if(isset($listing))
                    <x-button
                        text="Delete"
                        color="red"
                        icon="fa-trash"
                        onclick="openDeleteModal()"
                    />
                @endif
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="md:py-6 max-w-7xl mx-auto space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg md:rounded-2xl p-3 md:p-8 border border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="listingForm" class="space-y-8">
                @csrf
                @if(isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif

                <input type="hidden" name="delete_images" id="delete_images" value="[]">
                <input type="hidden" name="deleted_sections" id="deleted_sections" value="[]">

                <!-- Image Preview Section -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Listing Images</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Click on an image to delete it</span>
                    </div>

                    <div class="relative">
                        @if(isset($listing) && !empty($listing->images))
                            @php
                                $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                                $images = is_array($images) ? $images : [];
                            @endphp
                            <div id="image-display-carousel" class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory">
                                @foreach($images as $image)
                                    @if(is_string($image) && !empty($image))
                                        <div class="relative flex-shrink-0 group">
                                            <img src="{{ asset($image) }}" alt="Listing Image"
                                                 class="w-52 h-52 object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform">
                                            <button type="button" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-xl delete-image-button" data-image="{{ $image }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                                <label for="images" class="w-52 h-52 relative flex items-center justify-center flex-shrink-0 bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer border border-dashed border-gray-400 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    <svg class="w-12 h-12 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    <span class="absolute mt-16 text-sm font-medium text-gray-500 dark:text-gray-400">Add Image</span>
                                    <input type="file" id="images" name="images[]" multiple class="hidden" accept="image/*" onchange="previewImages(event)">
                                </label>
                            </div>
                        @else
                            <div id="image-display-carousel" class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory">
                                <label for="images" class="w-52 h-52 relative flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer border border-dashed border-gray-400 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    <svg class="w-12 h-12 text-gray-500 dark:text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Upload Images</span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 mt-1">PNG, JPG, GIF up to 10MB</span>
                                    <input type="file" id="images" name="images[]" multiple class="hidden" accept="image/*" onchange="previewImages(event)">
                                </label>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Business Details -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Business Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach (['title' => 'Title', 'category' => 'Category', 'location' => 'Location'] as $key => $label)
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                                <label for="{{ $key }}" class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                                <input type="text" name="{{ $key }}" id="{{ $key }}"
                                       class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100"
                                       value="{{ old($key, $listing->$key ?? '') }}" {{ $key === 'title' ? 'required' : '' }}>

                                @error($key)
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Listing Details -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Financial Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach (['price' => 'Price', 'revenue' => 'Revenue', 'profit' => 'Profit'] as $key => $label)
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                                <label for="{{ $key }}" class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }} ($)</label>
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                    </div>
                                    <input inputmode="numeric" type="number" step="0.01" name="{{ $key }}" id="{{ $key }}"
                                           class="pl-7 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100"
                                           value="{{ old($key, $listing->$key ?? '') }}">
                                </div>

                                @error($key)
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Contact Details -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach (['contact_email' => 'Contact Email', 'phone_number' => 'Phone Number', 'website' => 'Website'] as $key => $label)
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                                <label for="{{ $key }}" class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                                <input type="text" name="{{ $key }}" id="{{ $key }}"
                                       class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100"
                                       value="{{ old($key, $listing->$key ?? '') }}">

                                @error($key)
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Description</h3>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                        <textarea name="description" id="description" rows="6"
                                  class="w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100"
                                  required>{{ old('description', $listing->description ?? '') }}</textarea>

                        @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Business Sections -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Business Sections</h3>
                        <x-button
                            text="Add Section"
                            type="button"
                            onclick="addSection()"
                            color="blue"
                            icon="fa-plus"
                        />
                    </div>

                    <div id="sections-container" class="space-y-4">
                        @php
                            $sections = isset($listing) ? (json_decode($listing->sections ?? '[]', true) ?? []) : [];
                        @endphp
                        @if(count($sections) > 0)
                            @foreach ($sections as $section)
                                @php $sectionId = $section['id'] ?? uniqid(); @endphp
                                <div data-uuid="{{ $sectionId }}" class="section-entry bg-gray-50 dark:bg-gray-800 rounded-lg p-4 shadow-md border border-gray-200 dark:border-gray-700 relative">
                                    <input type="hidden" name="sections[{{ $sectionId }}][id]" value="{{ $sectionId }}">
                                    <button type="button" onclick="removeSection('{{ $sectionId }}', this)"
                                            class="absolute top-2 right-2 text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Section Title</label>
                                    <input type="text" name="sections[{{ $sectionId }}][title]" value="{{ $section['title'] ?? '' }}"
                                           class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100"
                                           required>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mt-2">Section Description</label>
                                    <textarea name="sections[{{ $sectionId }}][description]" rows="3"
                                              class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100"
                                              required>{{ $section['description'] ?? '' }}</textarea>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8 bg-gray-50 dark:bg-gray-800 rounded-lg border border-dashed border-gray-300 dark:border-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No sections yet</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Add sections to provide more details about the business</p>
                                <div class="mt-4">
                                    <button type="button" onclick="addSection()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Add First Section
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Mobile Action Buttons -->
    <div class="fixed bottom-0 z-10 w-full bg-white dark:bg-gray-900 border-t dark:border-gray-800 md:hidden shadow-lg">
        <div class="max-w-lg mx-auto px-4 py-3 flex space-x-3">
            <button type="submit" form="listingForm" class="flex-1 flex justify-center items-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ isset($listing) ? 'Update' : 'Create' }}
            </button>

            @if(isset($listing))
                <button type="button" onclick="openDeleteModal()" class="flex-1 flex justify-center items-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            @else
                <a href="{{ route('listings.index') }}" class="flex-1 flex justify-center items-center px-4 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-medium transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </a>
            @endif
        </div>
    </div>

    <!-- Delete Modal Component -->
    @if(isset($listing))
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex justify-center items-center hidden z-50 transition-opacity duration-300">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-2xl max-w-md w-full border border-gray-200 dark:border-gray-700 transform transition-all duration-300 scale-95 mx-4">
                <div class="text-center">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Delete Listing</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        Are you sure you want to delete this listing? This action cannot be undone.
                    </p>
                </div>

                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
                        Cancel
                    </button>

                    <form action="{{ route('listings.destroy', $listing) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                            Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Setup delete modal events
            document.getElementById('deleteModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeDeleteModal();
            });

            // Initialize tracking arrays for deleted items
            let deletedSectionsInput = document.getElementById("deleted_sections");
            let deletedImagesInput = document.getElementById("delete_images");
            let deletedSections = [];
            let deletedImages = [];

            // Setup event listeners for delete image buttons
            document.querySelectorAll('.delete-image-button').forEach(button => {
                button.addEventListener('click', function() {
                    let image = this.closest('div.relative');
                    if (image) {
                        let imagePath = this.getAttribute('data-image');
                        if (imagePath) {
                            deletedImages.push(imagePath);
                            deletedImagesInput.value = JSON.stringify(deletedImages);
                        }
                        image.remove();
                    }
                });
            });
        });

        function openDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.classList.remove('hidden');
                setTimeout(() => modal.querySelector('div').classList.remove('scale-95'), 10);
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.querySelector('div').classList.add('scale-95');
                setTimeout(() => modal.classList.add('hidden'), 200);
            }
        }

        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                let r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        function addSection() {
            let container = document.getElementById("sections-container");
            let emptyState = container.querySelector('.text-center');
            if (emptyState) {
                emptyState.remove();
            }

            let uuid = generateUUID();

            let div = document.createElement("div");
            div.classList.add("section-entry", "bg-gray-50", "dark:bg-gray-800", "rounded-lg", "p-4", "shadow-md", "border", "border-gray-200", "dark:border-gray-700", "relative");
            div.setAttribute("data-uuid", uuid);
            div.innerHTML = `
                <input type="hidden" name="sections[${uuid}][id]" value="${uuid}">
                <button type="button" onclick="removeSection('${uuid}', this)" class="absolute top-2 right-2 text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                <labelclass="block text-sm font-medium text-gray-600 dark:text-gray-300">Section Title</label>
                <input type="text" name="sections[${uuid}][title]" placeholder="E.g., Business Overview, Team, Financial Details" class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" required>
                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mt-2">Section Description</label>
                <textarea name="sections[${uuid}][description]" placeholder="Provide details for this section" class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 dark:text-gray-100" rows="3" required></textarea>
            `;

            container.appendChild(div);

            // Scroll to the new section
            setTimeout(() => {
                div.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        }

        function removeSection(uuid, button) {
            let section = button.closest(".section-entry");
            let container = document.getElementById("sections-container");
            let deletedSectionsInput = document.getElementById("deleted_sections");
            let deletedSections = JSON.parse(deletedSectionsInput.value || '[]');

            if (section) {
                // Fade out animation
                section.style.transition = "opacity 0.3s, transform 0.3s";
                section.style.opacity = "0";
                section.style.transform = "scale(0.95)";

                setTimeout(() => {
                    section.remove();
                    deletedSections.push(uuid);
                    deletedSectionsInput.value = JSON.stringify(deletedSections);

                    // Check if no sections remain and show empty state if needed
                    if (container.children.length === 0) {
                        container.innerHTML = `
                            <div class="text-center py-8 bg-gray-50 dark:bg-gray-800 rounded-lg border border-dashed border-gray-300 dark:border-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No sections yet</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Add sections to provide more details about the business</p>
                                <div class="mt-4">
                                    <button type="button" onclick="addSection()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Add First Section
                                    </button>
                                </div>
                            </div>
                        `;
                    }
                }, 300);
            }
        }

        function previewImages(event) {
            let imageDisplay = document.getElementById('image-display-carousel');
            let addButton = imageDisplay.querySelector('label');
            let files = event.target.files;

            for (let file of files) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    let div = document.createElement("div");
                    div.className = "relative flex-shrink-0 group";

                    let img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "w-52 h-52 object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform";
                    div.appendChild(img);

                    let deleteButton = document.createElement("button");
                    deleteButton.className = "absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-xl delete-image-button";
                    deleteButton.type = "button";
                    deleteButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    `;
                    deleteButton.onclick = function() { div.remove(); };
                    div.appendChild(deleteButton);

                    imageDisplay.insertBefore(div, addButton);
                };
                reader.readAsDataURL(file);
            }
        }

        // Make functions available globally
        window.addSection = addSection;
        window.removeSection = removeSection;
        window.previewImages = previewImages;
        window.openDeleteModal = openDeleteModal;
        window.closeDeleteModal = closeDeleteModal;
    </script>
</x-app-layout>
