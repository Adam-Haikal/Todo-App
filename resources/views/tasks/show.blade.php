<x-nav.layout>
    <div id="mainContent" class="relative">
        <x-slot:heading>
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-between">
                    {{-- Back button --}}
                    <a href="/tasks"
                        class="mr-4 rounded-lg bg-gray-200 text-gray-900 hover:bg-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-7">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </a>

                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ $list['list_name'] }}
                    </h1>
                </div>

                {{-- Add new task button --}}
                <a rel="stylesheet"
                    id="showTaskButton"
                    class="cursor-pointer">
                    <x-list.plus-button class="mx-4" />
                </a>
            </div>
        </x-slot:heading>


        @if ($tasks->count() == 0)
            <p>No tasks created</p>

            <a href="/tasks/edit"
                class="text-blue-500 hover:underline">Add new task</a>
        @endif

        {{-- Display tasks --}}
        @foreach ($tasks as $task)
            <ul class="rounded-lg border border-gray-200 bg-white shadow">
                <li class="flex w-full items-center rounded-t-lg border-b border-gray-600 ps-3 dark:border-gray-200">

                    <x-list.checkbox :task="$task" />

                    {{-- Task content --}}
                    <div class="mx-2 ms-2 flex w-full flex-col py-1">
                        <label for="{{ $task['id'] }}"
                            class="text-md font-bold text-gray-300 dark:text-gray-900">
                            {{ $task['task_name'] }}
                        </label>
                        <p class="text-sm font-medium italic text-gray-300 dark:text-gray-600">
                            {{ $task['description'] }}
                        </p>
                    </div>

                    <div class="w-3/12 self-start p-1">
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
    </div>

    {{-- Add new task form --}}
    <div id="createTaskForm"
        class="relative flex hidden justify-center">
        <form action="{{ route('tasks.addTask', $list->id) }}"
            method="POST"
            class="absolute flex w-full max-w-7xl flex-col justify-between rounded-lg border border-gray-200 bg-gray-100 p-4 shadow">
            @csrf

            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold text-gray-900">
                    Add New Task
                </h1>
                {{-- Close button --}}
                <x-list.button id="closeFormButton"
                    color="bg-red-500"
                    class="shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                    <x-list.button-icon stroke-width="1.5"
                        stroke="white"
                        fill="none">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12" />
                    </x-list.button-icon>
                </x-list.button>

            </div>

            <hr class="my-4">

            <label for="task_name">Task Name:</label>
            <input type="text"
                name="task_name"
                id="task_name"
                class="mb-2 h-10 w-1/2 rounded border border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                required>

            <label for="description">Description:</label>
            <textarea name="description"
                id="description"
                class="h-24 w-full rounded border border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"></textarea>

            <div class="flex items-center gap-2">
                <x-list.button color="bg-green-500"
                    size="h-8 max-w-sm"
                    type="submit"
                    value="submit"
                    class="mt-4 flex h-10 items-center justify-center rounded-lg border border-transparent px-4 font-medium text-white shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">Add</x-list.button>

                <x-list.button color="bg-red-500"
                    size="h-8 max-w-sm"
                    type="reset"
                    value="reset"
                    class="mt-4 flex h-10 items-center justify-center rounded-lg border border-transparent px-4 font-medium text-white shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">Delete</x-list.button>
            </div>
        </form>
    </div>
</x-nav.layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showTaskButton = document.getElementById('showTaskButton');
        const closeFormButton = document.getElementById('closeFormButton');
        const createTaskForm = document.getElementById('createTaskForm');
        const maiContent = document.getElementById('mainContent');

        // Show form when "Create New Task" button is clicked
        showTaskButton.addEventListener('click', () => {
            createTaskForm.classList.remove('hidden');
            mainContent.classList.add('backdrop-blur-md');
        });
        // Hide form when "Close" button is clicked
        closeFormButton.addEventListener('click', () => {
            createTaskForm.classList.add('hidden');
            mainContent.classList.remove('backdrop-blur-md');
        });
    });
</script>
