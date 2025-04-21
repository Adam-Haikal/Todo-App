@props(['type' => 'button', 'color', 'size' => 'h-9 w-9'])

<button type={{ $type }}
    {{ $attributes->merge(['class' => "$size shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 flex items-center justify-center rounded-lg "]) }}>
    {{ $slot }}
</button>
