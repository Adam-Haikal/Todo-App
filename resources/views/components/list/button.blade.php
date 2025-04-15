@props(['type' => 'submit', 'color', 'size' => 'h-8 w-8'])

<button type={{ $type }}
    {{ $attributes->merge(['class' => "$color $size flex items-center justify-center rounded-lg"]) }}>
    {{ $slot }}
</button>
