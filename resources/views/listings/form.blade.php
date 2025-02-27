<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 w-full">
                <div class="flex flex-col md:flex-row justify-center items-center space-y-2 md:space-y-0 md:space-x-4">
                    <h2 class="text-2xl text-center font-bold text-gray-900 dark:text-white">
                        {{ isset($listing) ? 'Edit Listing' : 'Create Listing' }}
                    </h2>
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-4">
                <x-button
                    text="{{ isset($listing) ? 'Update Listing' : 'Create Listing' }}"
                    type="submit"
                    form="listingForm"
                    color="green"
                />
                @if(isset($listing))
                    <x-button
                        text="Delete"
                        color="red"
                        onclick="openDeleteModal()"
                    />
                @endif
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="md:py-6 max-w-7xl mx-auto space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg md:rounded-2xl p-3 md:p-8 border border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="listingForm">
                @csrf
                @if(isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif

                <input type="hidden" name="delete_images" id="delete_images" value="[]">
                <input type="hidden" name="deleted_sections" id="deleted_sections" value="[]">

                <!-- Image Preview Section -->
                @if(isset($listing) && !empty($listing->images))
                    @php
                        $images = is_array($listing->images) ? $listing->images : json_decode($listing->images, true);
                        $images = is_array($images) ? $images : [];
                    @endphp
                    <div class="mb-8">
                        <div id="image-display-carousel" class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory">
                            @foreach($images as $image)
                                @if(is_string($image) && !empty($image))
                                    <div class="relative">
                                        <img src="{{ asset($image) }}" alt="Listing Image"
                                             class="h-96 w-full object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform">
                                        <button type="button" class="absolute top-2 right-2 bg-red-500 text-white p-2 px-3 rounded-full shadow-md delete-image-button" data-image="{{ $image }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                            <label for="images" class="relative flex items-center justify-center h-96 w-full bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer border border-dashed border-gray-400 dark:border-gray-600">
                                <svg class="w-12 h-12 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <input type="file" id="images" name="images[]" multiple class="hidden" accept="image/*" onchange="previewImages(event)">
                            </label>
                        </div>
                    </div>
                @else
                    <div class="mb-8">
                        <div id="image-display-carousel" class="flex overflow-x-auto space-x-4 pb-4 snap-x snap-mandatory">
                            <label for="images" class="relative flex items-center justify-center h-96 w-full bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer border border-dashed border-gray-400 dark:border-gray-600">
                                <svg class="w-12 h-12 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <input type="file" id="images" name="images[]" multiple class="hidden" accept="image/*" onchange="previewImages(event)">
                            </label>
                        </div>
                    </div>
                @endif

                <!-- Business Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @foreach (['title' => 'Title', 'category' => 'Category', 'location' => 'Location'] as $key => $label)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                            <input type="text" name="{{ $key }}" id="{{ $key }}"
                                   class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-gray-100"
                                   value="{{ old($key, $listing->$key ?? '') }}" {{ $key === 'title' ? 'required' : '' }}>
                        </div>
                    @endforeach
                </div>

                <!-- Listing Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @foreach (['price' => 'Price', 'revenue' => 'Revenue', 'profit' => 'Profit'] as $key => $label)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                            <input type="number" step="0.01" name="{{ $key }}" id="{{ $key }}"
                                   class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-gray-100"
                                   value="{{ old($key, $listing->$key ?? '') }}">
                        </div>
                    @endforeach
                </div>

                <!-- Contact Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @foreach (['contact_email' => 'Contact Email', 'phone_number' => 'Phone Number', 'website' => 'Website'] as $key => $label)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">{{ $label }}</label>
                            <input type="text" name="{{ $key }}" id="{{ $key }}"
                                   class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-gray-100"
                                   value="{{ old($key, $listing->$key ?? '') }}">
                        </div>
                    @endforeach
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Description</h3>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                        <textarea name="description" rows="4"
                                  class="w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-gray-100"
                                  required>{{ old('description', $listing->description ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Business Sections -->
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Business Sections</h3>
                    <div id="sections-container" class="space-y-4">
                        @php
                            $sections = isset($listing) ? (json_decode($listing->sections ?? '[]', true) ?? []) : [];
                        @endphp
                        @foreach ($sections as $section)
                            @php $sectionId = $section['id'] ?? uniqid(); @endphp
                            <div data-uuid="{{ $sectionId }}" class="section-entry bg-gray-50 dark:bg-gray-800 rounded-lg p-4 shadow-md border border-gray-200 dark:border-gray-700 relative">
                                <input type="hidden" name="sections[{{ $sectionId }}][id]" value="{{ $sectionId }}">
                                <button type="button" onclick="removeSection('{{ $sectionId }}', this)"
                                        class="absolute top-2 right-2 text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Title</label>
                                <input type="text" name="sections[{{ $sectionId }}][title]" value="{{ $section['title'] ?? '' }}"
                                       class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-gray-100"
                                       required>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mt-2">Description</label>
                                <textarea name="sections[{{ $sectionId }}][description]" rows="2"
                                          class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-gray-100"
                                          required>{{ $section['description'] ?? '' }}</textarea>
                            </div>
                        @endforeach
                    </div>
                    <x-button
                        text="+ Add Section"
                        type="button"
                        onclick="addSection()"
                        additional-classes="mt-4"
                    />
                </div>
            </form>
        </div>
    </div>

    <!-- Mobile Action Buttons -->
    <div class="fixed bottom-0 z-10 w-full bg-gray-50 dark:bg-gray-900 border-t dark:border-gray-800 md:hidden p-4 flex space-x-4">
        <x-button
            text="{{ isset($listing) ? 'Update Listing' : 'Create Listing' }}"
            type="submit"
            form="listingForm"
            color="green"
            additional-classes="flex-grow"
        />
        @if(isset($listing))
            <x-button
                text="Delete"
                color="red"
                type="button"
                onclick="openDeleteModal()"
            />
        @endif
    </div>

    <!-- Delete Modal Component -->
    @if(isset($listing))
        <x-delete-modal :listing="$listing" />
    @endif

    <script>
        function openDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.querySelector('div').classList.remove('scale-95'), 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }

        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        document.addEventListener("DOMContentLoaded", function () {
            let deletedSectionsInput = document.getElementById("deleted_sections");
            let deletedImagesInput = document.getElementById("delete_images");
            let deletedSections = [];
            let deletedImages = [];

            function generateUUID() {
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                    let r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            }

            function addSection() {
                let container = document.getElementById("sections-container");
                let uuid = generateUUID();

                let div = document.createElement("div");
                div.classList.add("section-entry", "bg-gray-50", "dark:bg-gray-800", "rounded-lg", "p-4", "shadow-md", "border", "border-gray-200", "dark:border-gray-700", "relative");
                div.setAttribute("data-uuid", uuid);

                div.innerHTML = `
                    <input type="hidden" name="sections[${uuid}][id]" value="${uuid}">
                    <button type="button" onclick="removeSection('${uuid}', this)" class="absolute top-2 right-2 text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                        <i class="fa fa-trash"></i>
                    </button>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300">Title</label>
                    <input type="text" name="sections[${uuid}][title]" placeholder="Section Title" class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-gray-100" required>
                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mt-2">Description</label>
                    <textarea name="sections[${uuid}][description]" placeholder="Section Description" class="mt-1 w-full rounded-lg bg-white dark:bg-gray-800 p-2 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-gray-100" rows="2" required></textarea>
                `;

                container.appendChild(div);
            }

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

            function previewImages(event) {
                let imageDisplay = document.getElementById('image-display-carousel');
                let files = event.target.files;

                for (let file of files) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        let div = document.createElement("div");
                        div.className = "relative";

                        let img = document.createElement("img");
                        img.src = e.target.result;
                        img.className = "h-96 w-full object-cover rounded-xl shadow-md border dark:border-gray-700 snap-center transition-transform ";
                        div.appendChild(img);

                        let deleteButton = document.createElement("button");
                        deleteButton.innerHTML = '<i class="fa fa-trash"></i>';
                        deleteButton.className = "absolute top-2 right-2 bg-red-500 text-white p-2 px-3 rounded-full shadow-md delete-image-button";
                        deleteButton.type = "button";
                        deleteButton.onclick = function() { div.remove(); };
                        div.appendChild(deleteButton);

                        imageDisplay.insertBefore(div, imageDisplay.lastElementChild);
                    };
                    reader.readAsDataURL(file);
                }
            }

            document.getElementById('images').addEventListener('change', previewImages);

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

            window.addSection = addSection;
            window.removeSection = removeSection;
        });
    </script>
</x-app-layout>
