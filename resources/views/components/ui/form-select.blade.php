@props(['name', 'label' => null, 'required' => false])

<div class="mb-5">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1.5">
            {{ $label }}@if($required)<span class="text-red-500 ml-0.5">*</span>@endif
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full border border-orange-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition']) }}
    >
        {{ $slot }}
    </select>

    @error($name)
        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
