<x-nav.layout>
    <x-slot:heading>
        Tasks
    </x-slot:heading>

    @if ($tasks->count() == 0)
        <p>No tasks created</p>

        <a href="/tasks/create"
            class="text-blue-500 hover:underline">Create a new task</a>
    @endif

    @foreach ($tasks as $task)
        <ul class="rounded-lg border border-gray-200 bg-gray-300">
            <li class="flex w-full items-center rounded-t-lg border-b border-gray-600 ps-3 dark:border-gray-200">

                <x-list.checkbox :task="$task" />

                {{-- Task content --}}
                <div class="mx-2 ms-2 flex w-full flex-col py-1">
                    <label for="{{ $task['id'] }}"
                        class="text-md font-bold text-gray-300 dark:text-gray-900">
                        {{ $task['title'] }}
                    </label>
                    <p class="text-sm font-medium italic text-gray-300 dark:text-gray-600">
                        {{ $task['description'] }}
                    </p>
                </div>

                <div class="w-3/12 self-start bg-amber-300 p-1">
                    @foreach ($task->tags as $tag)
                        <span
                            class="inline-flex rounded-md bg-green-300 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-green-500/10">{{ $tag->name }}
                        </span>
                    @endforeach
                </div>

                <form action="/"
                    method="POST"
                    class="my-3 mr-4 flex space-x-1">
                    @csrf

                    <x-list.edit-button />
                    <x-list.delete-button />
                </form>

            </li>
        </ul>
    @endforeach
</x-nav.layout>
