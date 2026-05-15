@props(['headers' => []])

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-orange-50 border-b border-orange-100">
                    @foreach($headers as $header)
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @isset($pagination)
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $pagination }}
        </div>
    @endisset
</div>
