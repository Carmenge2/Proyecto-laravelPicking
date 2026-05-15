@props(['href', 'active' => false, 'icon' => ''])

@php
    $classes = $active
        ? 'bg-orange-50 text-orange-700 font-semibold'
        : 'text-gray-600 hover:bg-orange-50 hover:text-orange-700';
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => "flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition $classes"]) }}>
    @if($icon)
        {!! $icon !!}
    @endif
    {{ $slot }}
</a>
