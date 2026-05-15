@props(['action', 'label' => '', 'message' => '¿Estás seguro de que deseas eliminar este elemento?'])

<form action="{{ $action }}" method="POST" class="inline"
      x-data="{ confirming: false }">
    @csrf
    @method('DELETE')

    <button type="button"
            x-show="!confirming"
            x-on:click="confirming = true"
            class="{{ $label ? 'inline-flex items-center gap-1.5 text-sm font-medium px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition' : 'text-red-500 hover:text-red-700 transition' }}"
            title="Eliminar">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
        </svg>
        @if($label) {{ $label }} @endif
    </button>

    <div x-show="confirming" x-cloak class="inline-flex items-center gap-1">
        <button type="submit"
                class="text-xs bg-red-600 hover:bg-red-700 text-white px-2.5 py-1 rounded-lg transition">
            Confirmar
        </button>
        <button type="button"
                x-on:click="confirming = false"
                class="text-xs bg-gray-200 hover:bg-gray-300 text-gray-700 px-2.5 py-1 rounded-lg transition">
            Cancelar
        </button>
    </div>
</form>
