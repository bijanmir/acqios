<div class="border rounded-lg p-4 shadow-md bg-white">
    <h3 class="text-xl font-bold text-gray-800">{{ $title }}</h3>
    <p class="text-gray-600">{{ $description }}</p>
    <p class="text-sm text-gray-500">
        Created: {{ $created_at->format('M d, Y') }} |
        Updated: {{ $updated_at->format('M d, Y') }}
    </p>
    @if ($images)
        <div class="mt-4 grid grid-cols-3 gap-2">
            @foreach ($images as $image)
                <img src="{{ asset($image->path) }}" alt="Image" class="w-full h-20 object-cover rounded">
            @endforeach
        </div>
    @endif
</div>
