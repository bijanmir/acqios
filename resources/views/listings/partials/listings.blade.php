@if ($listings->isEmpty())
    <p class="text-center text-gray-500">No listings found. Try different filters.</p>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($listings as $listing)
            <x-listing-card :listing="$listing" />
        @endforeach
    </div>
@endif
