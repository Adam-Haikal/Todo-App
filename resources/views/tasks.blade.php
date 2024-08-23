<x-layout>
    <x-slot:heading>
        Tasks
    </x-slot:heading>

    <h2 class="text-lg font-bold">{{ $tasks['title'] }}</h2>

    <p class="">{{ $tasks['description'] }}</p>

    <p>{{ $tasks['is_completed'] }}</p>
</x-layout>
