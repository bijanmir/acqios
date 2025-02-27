@php
    $colorClasses = match($color) {
        'black' => 'bg-black/80 hover:bg-black/50 border-white/20 hover:border-white/30 focus:ring-white/30',
        'green' => 'bg-green-600/80 hover:bg-green-500/50 border-green-400/20 hover:border-green-400/30 focus:ring-green-400/30',
        'blue' => 'bg-blue-600/80 hover:bg-blue-500/50 border-blue-400/20 hover:border-blue-400/30 focus:ring-blue-400/30',
        'red' => 'bg-red-600/80 hover:bg-red-500/50 border-red-400/20 hover:border-red-400/30 focus:ring-red-400/30',
        default => 'bg-gray-600/80 hover:bg-gray-500/50 border-gray-400/20 hover:border-gray-400/30 focus:ring-gray-400/30',
    };
@endphp

<button
    type="{{ $type }}"
    class="button-main {{ $colorClasses }} {{ $additionalClasses }}"
    {{ $attributes->merge(['class' => '']) }}
>
    {!! $text !!}
</button>
