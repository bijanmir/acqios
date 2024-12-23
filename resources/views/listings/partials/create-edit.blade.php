<div class="bg-white p-6 rounded shadow-md w-1/2">
    <h3 class="text-xl font-bold mb-4">{{ isset($listing) ? 'Edit Listing' : 'Create Listing' }}</h3>
    <form
        hx-post="{{ isset($listing) ? route('listings.update', $listing->id) : route('listings.store') }}"
        hx-target="#listings-container"
        hx-swap="innerHTML"
        class="space-y-4"
    >
        @csrf
        @if (isset($listing))
            @method('PUT')
        @endif

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input
                type="text"
                id="title"
                name="title"
                value="{{ $listing->title ?? '' }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                required
            />
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea
                id="description"
                name="description"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                rows="4"
                required
            >{{ $listing->description ?? '' }}</textarea>
        </div>

        <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600"
        >
            {{ isset($listing) ? 'Update Listing' : 'Create Listing' }}
        </button>
    </form>
</div>
