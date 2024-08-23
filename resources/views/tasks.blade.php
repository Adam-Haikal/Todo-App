<x-layout>
    <x-slot:heading>
        Tasks
    </x-slot:heading>

    @foreach ($tasks as $task)
        <h2 class="text-lg font-bold">{{ $task['title'] }}</h2>

        <p class="">{{ $task['description'] }}</p>

        <p>{{ $task['is_completed'] }}</p>
    @endforeach
</x-layout>
