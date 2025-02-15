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
                <div class="mb-8">
                    <div id="image-display-carousel" class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory">
                        @php
                            $initialImages = isset($listing) ? json_decode($listing->images, true) ?? [] : [];
                        @endphp
                        @foreach($initialImages as $image)
                            <div class="relative">
                                <img src="{{ asset($image) }}" alt="Listing Image"
                                     class="h-96 w-96 object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform hover:scale-105">
                                <button type="button" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full shadow-md delete-image-button" data-image="{{ $image }}">
                                    ✕
                                </button>
                            </div>
                        @endforeach

                        <!-- Placeholder for new image uploads -->
                        <label for="images" class="flex items-center justify-center h-96 w-96 bg-gray-200 dark:bg-gray-700 rounded-xl cursor-pointer upload-image-button border border-dashed border-gray-400 dark:border-gray-600">
                            <svg class="w-10 h-10 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                                    ✕
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
                            class="mt-2 px-4 py-2 bg-blue-500/80 dark:bg-blue-600/80 hover:bg-blue-600 dark:hover:bg-blue-700 text-white rounded-xl shadow-lg backdrop-blur-md transition-all duration-300 transform hover:scale-105">
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

<script>
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

        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Title</label>
        <input type="text" name="sections[${uuid}][title]" placeholder="Section Title"
               class="w-full rounded-lg bg-white/20 dark:bg-gray-800/30 text-gray-900 dark:text-white p-3 border border-white/30 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 shadow-md transition-all backdrop-blur-lg"
               required>

        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mt-2">Description</label>
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
