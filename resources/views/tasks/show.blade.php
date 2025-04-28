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
                id="showFormButton"
                name="showFormButton" />
        </div>
    </x-slot:heading>

    {{-- Overlay and Add Task forms --}}
    <div id="overlay"
        class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 backdrop-blur-sm"></div>

    <div
        class="fixed left-1/2 top-1/2 z-50 flex w-full max-w-md -translate-x-1/2 -translate-y-1/2 items-center justify-center md:max-w-7xl">
        @include('tasks.create-task-form')
        @include('tasks.update-task-form')
    </div>


    @if ($tasks->count() == 0)
        <p>No tasks created</p>

        <span name="showFormButton"
            class="cursor-pointer text-blue-500 hover:underline">Add new task
        </span>
    @endif

    {{-- Delete button --}}
    <form action="{{ route('tasks.destroyTask', $list->id) }}"
        method="POST"
        onsubmit="return confirm('Are you sure you want to delete the selected tasks?');">
        @csrf
        @method('DELETE')

        {{-- Button to toggle the visibility of checkboxes and delete button --}}
        @if ($tasks->count() > 0)
            <div class="my-2 flex items-center">
                <button type="button"
                    id="ShowDeleteModeButton"
                    class="h-9 rounded-lg bg-red-600 px-4 text-white hover:bg-red-700 focus:ring-red-700">
                    Delete Tasks
                </button>

                {{-- Button to enable checkbox to delete multiple lists --}}
                <x-list.delete-button type="submit"
                    id="deleteButton"
                    class="hidden rounded-l-lg rounded-r-none" />
                <x-list.close-button id="closeDeleteModeButton"
                    class="hidden h-9 w-9 rounded-l-none rounded-r-lg bg-gray-400 text-white hover:bg-gray-500 focus:ring-gray-700" />
            </div>
        @endif

        @foreach ($tasks as $task)
            <div class="flex items-center">

                {{-- Checkbox for selecting multiple tasks for delete --}}
                <input type="checkbox"
                    name="delete_task_ids[]"
                    class="mx-2 hidden h-5 w-5 border-gray-300 text-red-600 focus:ring-red-500"
                    value="{{ $task['id'] }}">

                {{-- Display tasks --}}
                <ul class="w-full rounded-lg border border-gray-200 bg-white shadow">
                    <li class="flex items-center rounded-t-lg border-b border-gray-200 ps-2">
                        {{-- Checkbox for marking task as completed --}}
                        <x-list.checkbox id="{{ $task['id'] }}"
                            is_completed="{{ $task['is_completed'] }}"
                            class="p-2"
                            name="is_completed" />

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
                            <x-list.edit-button name="edit-button"
                                data-task="{{ json_encode($task) }}" />
                        </div>
                    </li>
                </ul>
            </div>
        @endforeach
    </form>
</x-nav.layout>

<script src="{{ asset('js/toggleForm.js') }}"></script>
<script src="{{ asset('js/updateTask.js') }}"></script>
<script src="{{ asset('js/toggleDeleteButton.js') }}"></script>
