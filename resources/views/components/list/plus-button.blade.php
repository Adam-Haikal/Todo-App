<x-list.button color="bg-teal-500"
    {{ $attributes->merge(['class' => 'bg-teal-200']) }}>
    <x-list.button-icon fill="none"
        stroke="white"
        stroke-width="2.5">
        <path strokeLinecap="round"
            strokeLinejoin="round"
            d="M12 4.5v15m7.5-7.5h-15" />
    </x-list.button-icon>
</x-list.button>
