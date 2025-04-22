<x-nav.layout>
    <x-slot:heading>
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-between">
                {{-- Back button --}}
                <a href="/tasks">
                    <x-list.back-button class="mr-4" />
                </a>

                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $list['list_name'] }}
                </h1>
            </div>

            {{-- Add new task button --}}
            <x-list.plus-button class="mx-4"
                id="showFormButton" />
        </div>
    </x-slot:heading>

    {{-- Overlay and Add New Task form --}}
    <div id="overlay"
        class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 backdrop-blur-sm"></div>
    <div id="createForm"
        {{-- class="fixed inset-0 z-50 flex hidden items-center justify-center"> --}}
        class="fixed w-full md:max-w-7xl max-w-md top-1/2 left-1/2 z-50 hidden flex -translate-x-1/2 -translate-y-1/2 items-center justify-center">
        <form action="{{ route('tasks.addTask', $list->id) }}"
            method="POST"
            class="relative flex w-full max-w-7xl flex-col justify-between rounded-lg border border-gray-200 bg-gray-100 p-4 shadow">
            @csrf

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $list['list_name'] }}
                </h1>

                {{-- Close button --}}
                <x-list.close-button id="closeFormButton" />
            </div>

            <hr class="my-4">

            <div class="flex items-start gap-2">
                {{-- Mark task as completed: --}}
                <x-list.checkbox id="is_completed"
                    name="is_completed"
                    class="mt-6"
                    value=1 />

                <div class="flex w-full flex-col">
                    <label for="task_name">Task Name:</label>
                    <input type="text"
                        name="task_name"
                        id="task_name"
                        class="mb-2 h-10 w-1/2 rounded border border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                        required>

                    <label for="description">Description:</label>
                    <textarea name="description"
                        id="description"
                        class="h-24 max-h-64 w-full rounded border border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"></textarea>
                </div>
            </div>


            {{-- Submit and Delete buttons --}}
            <div class="flex items-center gap-2">
                <x-list.button size="h-9 max-w-sm"
                    type="submit"
                    value="submit"
                    class="mt-4 flex items-center justify-center rounded-lg border border-transparent bg-green-500 px-4 font-medium text-white shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">Add</x-list.button>

                <x-list.button size="h-9 max-w-sm"
                    type="reset"
                    value="reset"
                    class="mt-4 flex items-center justify-center rounded-lg border border-transparent bg-red-500 px-4 font-medium text-white shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">Delete</x-list.button>
            </div>
        </form>
    </div>

    @if ($tasks->count() == 0)
        <p>No tasks created</p>

        <a href="/tasks/edit"
            class="text-blue-500 hover:underline">Add new task</a>
    @endif

    {{-- Delete button --}}
    <form action="{{ route('tasks.deleteTask', $list->id) }}"
        method="POST"
        onsubmit="return confirm('Are you sure you want to delete the selected tasks?');">
        @csrf
        @method('DELETE')

        {{-- Button to enable checkbox to delete multiple lists --}}

        <x-list.delete-button type="submit" />
        {{-- Display tasks --}}
        @foreach ($tasks as $task)
            <ul class="rounded-lg border border-gray-200 bg-white shadow">
                <li class="flex w-full items-center rounded-t-lg border-b border-gray-200 ps-2">

                    {{-- Checkbox for selecting multiple lists --}}
                    {{-- <input type="checkbox"
                            name="task_ids[]"
                            id="deleteCheckbox"
                            class="h-5 w-5 border-gray-300 text-blue-600 focus:ring-blue-500"
                            value="{{ $task['id'] }}"> --}}

                    {{-- Checkbox for marking task as completed --}}
                    <x-list.checkbox id="{{ $task['id'] }}"
                        is_completed="{{ $task['is_completed'] }}"
                        class="rounded-full" />

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

                    <div class="my-3 mr-4 flex space-x-1">
                        <x-list.edit-button />
                        <x-list.delete-button />
                    </div>
                </li>
            </ul>
        @endforeach
    </form>
</x-nav.layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showFormButton = document.getElementById('showFormButton');
        const closeFormButton = document.getElementById('closeFormButton');
        const createForm = document.getElementById('createForm');
        const overlay = document.getElementById('overlay');
        const body = document.body;

        // Show form and everlay when "Create New Task" button is clicked
        const showForm = () => {
            createForm.classList.remove('hidden');
            overlay.classList.remove('hidden');
            body.classList.add('overflow-hidden'); // Prevent scrolling
        };
        // Hide form and overlay when clicking outside the form
        const hideForm = () => {
            console.log('Overlay clicked, hiding form...');
            createForm.classList.add('hidden');
            overlay.classList.add('hidden');
            body.classList.remove('overflow-hidden'); // Allow scrolling
        };
        showFormButton.addEventListener('click', showForm);
        closeFormButton.addEventListener('click', hideForm);
        overlay.addEventListener('click', hideForm);
    });
</script>
