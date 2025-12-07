@props([
    'href' => null,
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2 text-white '
          . 'bg-gradient-to-r from-[#16A34A] to-[#22C55E] hover:opacity-95 '
          . 'focus:outline-none focus:ring-2 focus:ring-[#22C55E]/40';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $base]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $base]) }}>
        {{ $slot }}
    </button>
@endif

