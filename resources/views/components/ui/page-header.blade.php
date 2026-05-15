@props(['title', 'action' => null, 'actionLabel' => null, 'actionRoute' => null, 'actionIcon' => null])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>

    @if($actionRoute)
        <a href="{{ $actionRoute }}"
           class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm transition">
            @if($actionIcon)
                {!! $actionIcon !!}
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
            @endif
            {{ $actionLabel }}
        </a>
    @endif

    {{ $slot }}
</div>
