@props(['label', 'value', 'icon' => null, 'color' => 'orange'])

@php
    $colors = [
        'orange' => 'bg-orange-100 text-orange-600',
        'green' => 'bg-green-100 text-green-600',
        'blue' => 'bg-blue-100 text-blue-600',
        'red' => 'bg-red-100 text-red-600',
        'purple' => 'bg-purple-100 text-purple-600',
    ];
    $iconColor = $colors[$color] ?? $colors['orange'];
@endphp

<div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4">
    @if($icon)
        <div class="shrink-0 w-12 h-12 rounded-xl {{ $iconColor }} flex items-center justify-center">
            {!! $icon !!}
        </div>
    @endif
    <div>
        <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>
        <p class="text-sm text-gray-500">{{ $label }}</p>
    </div>
</div>
