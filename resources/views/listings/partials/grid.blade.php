<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @if (count($listings) < 1)
        <div class="text-center text-gray-500">
            No listings available.
        </div>
    @else
        @foreach ($listings as $listing)
            <x-listing-card
                :title="$listing->title"
                :description="$listing->description"
                :created_at="$listing->created_at"
                :updated_at="$listing->updated_at"
                :images="$listing->images"
            />
        @endforeach
    @endif
</div>
