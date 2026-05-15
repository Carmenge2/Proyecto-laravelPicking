<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-2.5 bg-white border border-orange-200 rounded-xl font-semibold text-sm text-gray-700 shadow-sm hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
