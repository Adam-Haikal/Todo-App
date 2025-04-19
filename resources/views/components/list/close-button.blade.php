@props(['id' ])

<x-list.button class="bg-red-500 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1"
    id="{{ $id }}">
    <x-list.button-icon stroke-width="1.5"
        stroke="white"
        fill="none">
        <path stroke-linecap="round"
            stroke-linejoin="round"
            d="M6 18 18 6M6 6l12 12" />
    </x-list.button-icon>
</x-list.button>
