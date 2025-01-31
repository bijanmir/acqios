<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 text-center">
            {{ isset($listing) ? 'Edit Listing' : 'Create Listing' }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="listingForm">
                @csrf
                @if (isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif
                <input type="hidden" name="delete_images" id="delete_images" value="[]">
                <input type="hidden" name="deleted_sections" id="deleted_sections" value="[]">

                <!-- Image Preview Section -->
                <div id="imagePreview" class="mb-6">
                    <h4 class="text-lg font-semibold">Current Images</h4>
                    <div id="image-display-carousel" class="flex overflow-x-auto space-x-4 pb-4">
                        @if(isset($listing) && !empty($listing->images))
                            @php
                                $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                                $images = is_array($images) ? $images : [];
                            @endphp
                            @foreach($images as $image)
                                <div class="relative image-container">
                                    <img src="{{ asset($image) }}" alt="Listing Image" class="w-52 h-52 object-cover rounded-lg shadow-md">
                                    <button type="button" class="absolute top-0 right-0 bg-red-500 text-white p-1 px-2 rounded-full delete-image-button"
                                            data-image="{{ $image }}">✕</button>
                                </div>
                            @endforeach
                        @endif
                        <!-- Upload New Images -->
                        <label for="images" class="flex items-center justify-center h-52 w-52 bg-gray-200 dark:bg-gray-700 rounded cursor-pointer upload-image-button">
                            <svg class="w-10 h-10 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <input type="file" id="images" name="images[]" multiple class="hidden" accept="image/*" onchange="previewImages(event)">
                        </label>
                    </div>
                </div>

                <!-- Title & Description -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium">Title</label>
                    <input type="text" name="title" id="title" class="w-full rounded-md border-gray-300"
                           value="{{ old('title', $listing->title ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300"
                              required>{{ old('description', $listing->description ?? '') }}</textarea>
                </div>

                <!-- Business Details -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium">Price</label>
                        <input type="number" step="0.01" name="price" id="price" class="w-full rounded-md border-gray-300"
                               value="{{ old('price', $listing->price ?? '') }}">
                    </div>
                    <div>
                        <label for="revenue" class="block text-sm font-medium">Revenue</label>
                        <input type="number" step="0.01" name="revenue" id="revenue" class="w-full rounded-md border-gray-300"
                               value="{{ old('revenue', $listing->revenue ?? '') }}">
                    </div>
                    <div>
                        <label for="profit" class="block text-sm font-medium">Profit</label>
                        <input type="number" step="0.01" name="profit" id="profit" class="w-full rounded-md border-gray-300"
                               value="{{ old('profit', $listing->profit ?? '') }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="category" class="block text-sm font-medium">Category</label>
                        <input type="text" name="category" id="category" class="w-full rounded-md border-gray-300"
                               value="{{ old('category', $listing->category ?? '') }}">
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium">Location</label>
                        <input type="text" name="location" id="location" class="w-full rounded-md border-gray-300"
                               value="{{ old('location', $listing->location ?? '') }}">
                    </div>
                    <div>
                        <label for="years_in_business" class="block text-sm font-medium">Years in Business</label>
                        <input type="number" name="years_in_business" id="years_in_business" class="w-full rounded-md border-gray-300"
                               value="{{ old('years_in_business', $listing->years_in_business ?? '') }}">
                    </div>

                </div>

                <!-- Additional Business Details -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">

                    <div>
                        <label for="contact_email" class="block text-sm font-medium">Contact Email</label>
                        <input type="email" name="contact_email" id="contact_email" class="w-full rounded-md border-gray-300"
                               value="{{ old('contact_email', $listing->contact_email ?? '') }}">
                    </div>
                    <div>
                        <label for="phone_number" class="block text-sm font-medium">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" class="w-full rounded-md border-gray-300"
                               value="{{ old('phone_number', $listing->phone_number ?? '') }}">
                    </div>
                    <div>
                        <label for="website" class="block text-sm font-medium">Website</label>
                        <input type="text" name="website" id="website" class="w-full rounded-md border-gray-300"
                               value="{{ old('website', $listing->website ?? '') }}">
                    </div>
                </div>





                <!-- Business Sections -->
                <div class="mb-4 mt-6">
                    <label class="block text-sm font-medium">Business Sections</label>
                    <div id="sections-container">
                        @php
                            $sections = old('sections', json_decode($listing->sections ?? '[]', true) ?? []);
                        @endphp
                        @foreach ($sections as $index => $section)
                            <div class="section-entry mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg" data-uuid="{{ $section['id'] }}">
                                <input type="hidden" name="sections[{{ $section['id'] }}][id]" value="{{ $section['id'] }}"> <!-- ✅ Hidden UUID -->

                                <div class="flex justify-between">
                                   <div></div>
                                    <button type="button" onclick="removeSection('{{ $section['id'] }}', this)" class="text-red-500 font-bold px-2">✕</button>
                                </div>

                                <input type="text" name="sections[{{ $section['id'] }}][title]" placeholder="Section Title"
                                       class="w-full border-gray-300 rounded-md p-2 mt-2 section-input"
                                       value="{{ $section['title'] ?? '' }}" required>

                                <textarea name="sections[{{ $section['id'] }}][description]" placeholder="Section Description"
                                          class="w-full border-gray-300 rounded-md p-2 mt-2" rows="3" required>{{ $section['description'] ?? '' }}</textarea>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-section" class="mt-2 bg-blue-500 text-white px-3 py-1 rounded-md" onclick="addSection()">
                        + Add Section
                    </button>

                </div>



                <!-- Submit -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        {{ isset($listing) ? 'Update Listing' : 'Create Listing' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Handling Images & Sections -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let deleteImagesInput = document.getElementById("delete_images");
            let deleteImagesArray = [];
            let uploadedImages = new Set(); // Track uploaded images to prevent duplicates

            document.querySelectorAll(".delete-image-button").forEach(button => {
                button.addEventListener("click", function () {
                    let imageUrl = this.dataset.image;
                    deleteImagesArray.push(imageUrl);
                    deleteImagesInput.value = JSON.stringify(deleteImagesArray);
                    this.closest(".image-container").remove();
                });
            });

            document.getElementById("images").addEventListener("change", function(event) {
                previewImages(event, uploadedImages);
            });
        });

        function previewImages(event, uploadedImages) {
            const imageCarousel = document.getElementById('image-display-carousel');
            const uploadButton = document.querySelector('.upload-image-button');
            const files = event.target.files;

            for (let file of files) {
                if (file.type.startsWith('image/') && !uploadedImages.has(file.name)) {
                    uploadedImages.add(file.name); // Prevent duplicate previews

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = document.createElement('div');
                        div.className = 'relative image-container';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-52 h-52 object-cover rounded-lg shadow-md';

                        const button = document.createElement('button');
                        button.className = 'absolute top-0 right-0 bg-red-500 text-white p-1 px-2 rounded-full delete-image-button';
                        button.innerHTML = '✕';
                        button.onclick = function () {
                            div.remove();
                            uploadedImages.delete(file.name); // Remove from tracking
                        };

                        div.appendChild(img);
                        div.appendChild(button);
                        imageCarousel.insertBefore(div, uploadButton);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }



        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        function addSection() {
            let container = document.getElementById("sections-container");
            let uuid = generateUUID(); // Generate a unique ID for each section

            let div = document.createElement("div");
            div.classList.add("section-entry", "mb-4", "p-4", "bg-gray-100", "dark:bg-gray-700", "rounded-lg");
            div.setAttribute("data-uuid", uuid);

            div.innerHTML = `
        <input type="hidden" name="sections[${uuid}][id]" value="${uuid}">
        <div class="flex justify-between">
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 section-title">New Section</h4>
            <button type="button" onclick="removeSection('${uuid}', this)" class="text-red-500 font-bold px-2">✕</button>
        </div>
        <input type="text" name="sections[${uuid}][title]" placeholder="Section Title"
               class="w-full border-gray-300 rounded-md p-2 mt-2 section-input" required>
        <textarea name="sections[${uuid}][description]" placeholder="Section Description"
                  class="w-full border-gray-300 rounded-md p-2 mt-2" rows="3" required></textarea>
    `;

            container.appendChild(div);
        }

        function removeSection(uuid, button) {
            let section = document.querySelector(`[data-uuid="${uuid}"]`);
            if (section) section.remove();

            let deletedSectionsInput = document.getElementById("deleted_sections");
            let deletedSections = JSON.parse(deletedSectionsInput.value || "[]");
            deletedSections.push(uuid);
            deletedSectionsInput.value = JSON.stringify(deletedSections);
        }



    </script>



</x-app-layout>
