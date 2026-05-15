@props(['name', 'label' => null, 'type' => 'text', 'value' => '', 'required' => false, 'placeholder' => ''])

<div class="mb-5">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1.5">
            {{ $label }}@if($required)<span class="text-red-500 ml-0.5">*</span>@endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full border border-orange-200 rounded-xl px-4 py-2.5 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition']) }}
    >

    @error($name)
        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
