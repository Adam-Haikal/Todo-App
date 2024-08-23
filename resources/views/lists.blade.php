<x-layout>
    <x-slot:heading>
        Lists
    </x-slot:heading>

    <ul>
        @if ($lists->count() == 0)
            <p>No lists found</p>

            <a href="/tasks/create" class="text-blue-500 hover:underline">Create a new list</a>
        @endif

        @foreach ($lists as $list)
            <a href="/tasks/{{ $list['id'] }}" onclick="console.log({{ $list['id'] }})"
                class="text-blue-500">
                <li class=" hover:underline">
                    <strong>
                        {{-- {{ $task['title'] }}: --}}
                        {{ $list['name'] }}
                    </strong>
                    {{-- {{ $task['description'] }} --}}
                </li>

                <li class="text-gray-500">
                    {{-- {{ $task['is_completed'] }} --}}
                    Last updated: {{ $list['updated_at'] }}
                </li>
            </a>
        @endforeach
    </ul>
</x-layout>
