<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div class="flex flex-col justify-center items-center space-y-2">
                <h2 class="text-2xl mx-2 text-center">
                    {{ isset($listing) ? 'Edit Listing' : 'Create Listing' }}
                </h2>
            </div>

            <!-- Fixed Update Button for Desktop -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Update Button -->
                <x-button
                    text="{{ isset($listing) ? 'Update Listing' : 'Create Listing' }}"
                    type="submit"
                    form="listingForm"
                />

                @if(isset($listing))
                    <!-- Delete Button (Triggers Confirmation Modal) -->
                <x-button
                    text="Delete"
                    color="red"
                    onclick="showDeleteModal()"

                />
                @endif
            </div>

            <!-- Delete Confirmation Modal -->
            @if(isset($listing))
                <div id="delete-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-11/12 max-w-md">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Are you sure?</h2>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">This action cannot be undone.</p>
                        <div class="flex justify-end space-x-4">
                            <button onclick="hideDeleteModal()"
                                    class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg shadow-md hover:bg-gray-400 dark:hover:bg-gray-600">
                                Cancel
                            </button>
                            <form id="delete-listing-form" method="POST" action="{{ route('listings.destroy', $listing->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
                                    Yes, Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </x-slot>

    <div class="md:py-6 max-w-7xl mx-auto space-y-6">
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
                <div class="mb-8">
                    <div id="image-display-carousel"
                         class="flex space-x-4 overflow-x-auto snap-x  w-full sm:w-auto snap-mandatory">

                    @php
                            $initialImages = isset($listing) ? json_decode($listing->images, true) ?? [] : [];
                        @endphp
                        @foreach($initialImages as $image)
                            <div class="relative ">
                                <img src="{{ asset($image) }}" alt="Listing Image"
                                     class="min-w-96 min-h-96 object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform ">
                                <button type="button" class="absolute top-2 right-2 bg-red-500 text-white p-2 px-3 rounded-full shadow-md delete-image-button" data-image="{{ $image }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        @endforeach

                        <!-- Placeholder for new image uploads -->
                        <label for="images" class="relative flex items-center justify-center min-h-96 min-w-96  bg-gray-200 dark:bg-gray-700 rounded-xl cursor-pointer border border-dashed border-gray-400 dark:border-gray-600">
                            <svg class="w-12 h-12 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <input type="file" id="images" name="images[]" multiple class="hidden" accept="image/*" onchange="previewImages(event)">
                        </label>

                    </div>
                </div>
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
                        @php
                            $sections = json_decode($listing->sections ?? '[]', true);
                            $sections = is_array($sections) ? $sections : [];
                        @endphp

                        @foreach ($sections as $section)
                            @php
                                $sectionId = $section['id'] ?? uniqid(); // Ensure each section has an ID
                            @endphp

                            <div data-uuid="{{ $sectionId }}" class="section-entry relative bg-white/30 dark:bg-gray-900/30 backdrop-blur-xl p-4 rounded-xl shadow-md border border-white/40 dark:border-gray-700 mb-4 transition-all">
                                <input type="hidden" name="sections[{{ $sectionId }}][id]" value="{{ $sectionId }}">

                                <!-- Delete Button -->
                                <button type="button" onclick="removeSection('{{ $sectionId }}', this)"
                                        class="absolute top-2 right-2 text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-bold px-3 py-1 rounded-full bg-white/40 dark:bg-gray-800/40 shadow-md transition-all hover:scale-110">
                                    <i class="fa fa-trash"></i>
                                </button>

                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Title</label>
                                <input type="text" name="sections[{{ $sectionId }}][title]" value="{{ $section['title'] ?? '' }}"
                                       class="w-full rounded-lg bg-white/20 dark:bg-gray-800/30 text-gray-900 dark:text-white p-3 border border-white/30 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 shadow-md transition-all backdrop-blur-lg"
                                       required>

                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mt-2">Description</label>
                                <textarea name="sections[{{ $sectionId }}][description]" rows="2"
                                          class="w-full rounded-lg bg-white/20 dark:bg-gray-800/30 text-gray-900 dark:text-white p-3 border border-white/30 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 shadow-md transition-all backdrop-blur-lg"
                                          required>{{ $section['description'] ?? '' }}</textarea>
                            </div>
                        @endforeach

                    </div>

                    <!-- Add Section Button -->
                    <button type="button" onclick="addSection()"
                            class="button-main">
                        + Add Section
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sticky "Update Listing" Button for Mobile -->
    <div class="fixed bottom-0 flex flex-row items-center justify-between z-10 w-full bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-md p-4 md:hidden space-x-4">

        <!-- Update Button -->
        <button type="submit" form="listingForm"
                class="flex-grow px-6 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 text-center font-bold">
            {{ isset($listing) ? 'Update Listing' : 'Create Listing' }}
        </button>

        @if(isset($listing))
            <!-- Delete Button (Smaller, More Spaced) -->
            <button type="button" onclick="showDeleteModal()"
                    class="button-main">
                <i class="fa fa-trash"></i> Delete
            </button>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    @if(isset($listing))
        <div id="delete-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-11/12 max-w-md">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Are you sure?</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-6">This action cannot be undone.</p>
                <div class="flex justify-end space-x-4">
                    <button onclick="hideDeleteModal()"
                            class="px-4 py-2 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg shadow-md hover:bg-gray-400 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <form id="delete-listing-form" method="POST" action="{{ route('listings.destroy', $listing->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
                            Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif


</x-app-layout>

<script>function showDeleteModal() {
        document.getElementById('delete-modal').classList.remove('hidden');

    }


    function hideDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');

    }


    function confirmDelete() {
        if (confirm("Are you sure you want to delete this listing? This action cannot be undone.")) {
            document.getElementById('delete-listing-form').submit();
        }
    }


    document.addEventListener("DOMContentLoaded", function () {
        let deletedSectionsInput = document.getElementById("deleted_sections");
        let deletedImagesInput = document.getElementById("delete_images");
        let deletedSections = [];
        let deletedImages = [];

        // Function to generate a UUID for new sections
        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                let r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        // Function to add a new section dynamically
        function addSection() {
            let container = document.getElementById("sections-container");
            let uuid = generateUUID();

            let div = document.createElement("div");
            div.classList.add("section-entry", "relative", "bg-white/30", "dark:bg-gray-900/30", "backdrop-blur-xl", "p-4", "rounded-xl", "shadow-md", "border", "border-white/40", "dark:border-gray-700", "mb-4", "transition-all");
            div.setAttribute("data-uuid", uuid);

            div.innerHTML = `
        <input type="hidden" name="sections[${uuid}][id]" value="${uuid}">

        <!-- Delete Button -->
        <button type="button" onclick="removeSection('${uuid}', this)"
                class="absolute top-2 right-2 text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-bold px-3 py-1 rounded-full bg-white/40 dark:bg-gray-800/40 shadow-md transition-all hover:scale-110">
            ✕
        </button>

        <input type="text" name="sections[${uuid}][title]" placeholder="Section Title"
               class="w-full rounded-lg bg-white/20 dark:bg-gray-800/30 text-gray-900 dark:text-white p-3 border border-white/30 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 shadow-md transition-all backdrop-blur-lg"
               required>

        <textarea name="sections[${uuid}][description]" placeholder="Section Description"
                  class="w-full rounded-lg bg-white/20 dark:bg-gray-800/30 text-gray-900 dark:text-white p-3 border border-white/30 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 shadow-md transition-all backdrop-blur-lg"
                  rows="3" required></textarea>
    `;

            container.appendChild(div);
        }

        // Function to remove a section dynamically
        function removeSection(uuid, button) {
            let section = button.closest(".section-entry");
            if (section) {
                section.classList.add("opacity-0", "scale-95");

                setTimeout(() => {
                    section.remove();
                    deletedSections.push(uuid);
                    deletedSectionsInput.value = JSON.stringify(deletedSections);
                }, 200);
            }
        }

        // Function to handle image preview
        function previewImages(event) {
            let imageDisplay = document.getElementById('image-display-carousel');
            let files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let reader = new FileReader();
                reader.onload = function (e) {
                    let div = document.createElement("div");
                    div.className = "relative";

                    let img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "h-96 w-96 object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform hover:scale-105";
                    div.appendChild(img);

                    let deleteButton = document.createElement("button");
                    deleteButton.textContent = "✕";
                    deleteButton.className = "absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full shadow-md delete-image-button";
                    deleteButton.type = "button";
                    deleteButton.onclick = function() {
                        div.remove();
                    };
                    div.appendChild(deleteButton);

                    // Insert before the upload button
                    let uploadButton = document.querySelector('.upload-image-button');
                    imageDisplay.insertBefore(div, uploadButton);
                };
                reader.readAsDataURL(file);
            }
        }

        // Event listener for new image uploads
        document.getElementById('images').addEventListener('change', previewImages);

        // Event listener for deleting existing images
        document.querySelectorAll('.delete-image-button').forEach(button => {
            button.addEventListener('click', function() {
                let image = this.closest('div');
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



        // Expose functions to global scope for inline button onclicks
        window.addSection = addSection;
        window.removeSection = removeSection;
    });

</script>
