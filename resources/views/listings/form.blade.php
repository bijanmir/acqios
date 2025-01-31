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
                <!-- Hidden Input for Deleted Images -->
                <input type="hidden" name="delete_images" id="delete_images" value="[]">

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

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-300 border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ old('title', $listing->title ?? '') }}" required>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-300 border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                              required>{{ old('description', $listing->description ?? '') }}</textarea>
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        {{ isset($listing) ? 'Update Listing' : 'Create Listing' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Handling Image Deletion & Preview -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let deleteImagesInput = document.getElementById("delete_images");
            let deleteImagesArray = [];

            document.querySelectorAll(".delete-image-button").forEach(button => {
                button.addEventListener("click", function () {
                    let imageUrl = this.dataset.image;
                    deleteImagesArray.push(imageUrl);
                    deleteImagesInput.value = JSON.stringify(deleteImagesArray);

                    // Remove the image from preview
                    this.closest(".image-container").remove();
                });
            });
        });

        function previewImages(event) {
            const imageCarousel = document.getElementById('image-display-carousel');
            const uploadButton = document.querySelector('.upload-image-button'); // The upload button container
            const files = event.target.files;

            if (!files.length) return; // Stop if no files are selected

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = document.createElement('div');
                        div.className = 'relative image-container';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-52 h-52 object-cover rounded-lg shadow-md';

                        const deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full delete-image-button';
                        deleteButton.textContent = '✕';

                        deleteButton.onclick = function () {
                            div.remove();
                        };

                        div.appendChild(img);
                        div.appendChild(deleteButton);

                        // **Insert the preview BEFORE the upload button**
                        imageCarousel.insertBefore(div, uploadButton);
                    };

                    reader.readAsDataURL(file);
                }
            }
        }


    </script>
</x-app-layout>
