@props(['type' => 'submit', 'color'])

<button type={{ $type }}
    class="{{ $color }} flex h-8 w-8 items-center justify-center rounded-lg">
    {{ $slot }}
</button>
