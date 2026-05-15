@props(['variant' => 'primary', 'tag' => 'button', 'href' => null])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-medium px-5 py-2.5 rounded-xl transition text-sm';

    $variants = [
        'primary' => 'bg-orange-500 hover:bg-orange-600 text-white shadow-sm',
        'secondary' => 'bg-white border border-orange-300 text-orange-600 hover:bg-orange-50',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white shadow-sm',
        'ghost' => 'text-orange-600 hover:text-orange-700 hover:bg-orange-50',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
