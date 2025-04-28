@props(['id', 'is_completed' => false])

{{-- Checkbox component for marking tasks as completed --}}
<input type="checkbox"
    id="{{ $id }}"
    name="{{ $attributes->get('name') }}"
    {{ $is_completed ? 'checked' : '' }}
    {{ $attributes->merge([
        'class' =>
            'appearance-none h-5 w-5 rounded-full border-2 border-gray-300 bg-gray-100 cursor-pointer relative checked:bg-green-600 checked:border-green-600 checked:after:content-[""] checked:after:absolute checked:after:top-1/2 checked:after:left-1/2 checked:after:transform checked:after:-translate-x-1/2 checked:after:-translate-y-1/2 checked:after:w-2 checked:after:h-2 checked:after:bg-white checked:after:rounded-full',
    ]) }}>

{{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
  </svg> --}}
