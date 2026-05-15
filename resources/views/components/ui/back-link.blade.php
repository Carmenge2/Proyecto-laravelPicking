@props(['href', 'label' => 'Volver'])

<a href="{{ $href }}" class="inline-flex items-center gap-1 text-sm font-medium text-orange-600 hover:text-orange-700 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
    </svg>
    {{ $label }}
</a>
