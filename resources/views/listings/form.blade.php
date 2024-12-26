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

                <!-- Scrollable Image Section -->
                <div id="imagePreview" class="mb-6">
                    <div class="flex overflow-x-auto space-x-4 pb-4">
                        @if(isset($listing) && $listing->images)
                            @foreach(json_decode($listing->images, true) as $image)
                                <div class="relative">
                                    <img src="{{ $image }}" alt="Listing Image" class="h-52 object-cover rounded">
                                    <button type="button" onclick="confirmDeleteImage('{{ $image }}')" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">X</button>
                                </div>
                            @endforeach
                        @endif
                        <label for="images" class="flex items-center justify-center h-52 w-52 bg-gray-200 dark:bg-gray-700 rounded cursor-pointer">
                            <svg class="w-10 h-10 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <input type="file" id="images" name="images[]" multiple class="hidden" accept="image/*" onchange="previewImages(event)">
                        </label>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="mt-4">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-300 border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('title', $listing->title ?? '') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md shadow-sm dark:bg-gray-900 dark:text-gray-300 border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                  required>{{ old('description', $listing->description ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between mt-6">
                    @if(isset($listing))
                        <a href="#" onclick="confirmDeleteListing('{{ route('listings.destroy', $listing->id) }}')" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Delete Listing
                        </a>
                    @endif
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        {{ isset($listing) ? 'Update Listing' : 'Create Listing' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for handling image preview, deletion, and listing deletion -->
    <script>
        function previewImages(event) {
            const imagePreview = document.getElementById('imagePreview').firstElementChild;
            const files = event.target.files;

            // Preview each selected image and insert before the plus button
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Selected Image';
                        img.className = 'h-52 object-cover rounded';

                        const div = document.createElement('div');
                        div.className = 'relative';
                        div.appendChild(img);

                        // Add delete button functionality for preview images
                        const deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs';
                        deleteButton.textContent = 'X';
                        deleteButton.onclick = function() {
                            div.remove();
                        };
                        div.appendChild(deleteButton);

                        // Insert the new preview image before the plus button
                        imagePreview.insertBefore(div, imagePreview.lastElementChild);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        function confirmDeleteImage(imageUrl) {
            if (confirm('Are you sure you want to remove this image?')) {
                let deleteImages = JSON.parse(document.getElementById('delete_images').value);
                deleteImages.push(imageUrl);
                document.getElementById('delete_images').value = JSON.stringify(deleteImages);
                // Visually remove the image from the DOM for immediate feedback
                document.querySelector(`img[src="${imageUrl}"]`).closest('div').remove();
            }
        }

        function confirmDeleteListing(url) {
            if (confirm('Are you sure you want to delete this listing? This action cannot be undone.')) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                document.body.appendChild(form);
                form.innerHTML = '@csrf @method("DELETE")';
                form.submit();
            }
        }
    </script>
</x-app-layout>
