@props(['id', 'is_completed' => false])

{{-- Checkbox component for marking tasks as completed --}}

<input type="checkbox"
    id="{{ $id }}"
    name="{{ $attributes->get('name') }}"
    {{ $is_completed ? 'checked' : '' }}
    {{ $attributes->merge(['class' => 'h-5 w-5 border-gray-300 bg-gray-100 text-blue-600 focus:ring-1 focus:ring-offset-1 focus:ring-blue-500']) }}>
