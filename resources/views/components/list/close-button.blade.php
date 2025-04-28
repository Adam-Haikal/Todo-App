@props(['id'])

<x-list.button id="{{ $id }}"
    {{ $attributes->merge(['class' => 'shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1']) }}>
    <x-list.button-icon fill="none"
        stroke="white"
        stroke-width="1.5">
        <path stroke-linecap="round"
            stroke-linejoin="round"
            d="M6 18 18 6M6 6l12 12" />
    </x-list.button-icon>
</x-list.button>
