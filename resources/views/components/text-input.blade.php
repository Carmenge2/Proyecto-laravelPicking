@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-orange-200 text-gray-700 focus:border-orange-400 focus:ring-orange-400 rounded-xl shadow-sm transition']) }}>
