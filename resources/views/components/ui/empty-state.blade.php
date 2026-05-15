@props(['message' => 'No hay datos disponibles.', 'actionLabel' => null, 'actionRoute' => null])

<div class="flex flex-col items-center justify-center py-12 text-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-orange-200 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>
    </svg>
    <p class="text-gray-500 text-sm mb-4">{{ $message }}</p>

    @if($actionRoute)
        <a href="{{ $actionRoute }}"
           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-medium px-4 py-2 rounded-xl text-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            {{ $actionLabel }}
        </a>
    @endif
</div>
