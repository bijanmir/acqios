@extends('layouts.app')

@section('content')
    <div class="listings-header flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Listings</h2>
        <button
            hx-get="/listings/create"
            hx-target="#modal"
            hx-trigger="click"
            class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600"
            onclick="handleCreateListing(this)"
        >
            Create Listing
        </button>
    </div>

    <div id="listings-container" hx-get="listings/content" hx-trigger="load" hx-target="#listings-container">
        <div class="text-center text-gray-500">Loading listings...</div>
    </div>



    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <!-- Dynamic HTMX content will load here -->
    </div>
@endsection

<script>
    function handleCreateListing (button) {
        const modal = button.closest('#main').querySelector('#modal')
        modal.classList.remove('hidden')
    }
</script>
