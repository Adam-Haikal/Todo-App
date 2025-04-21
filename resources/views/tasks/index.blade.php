<x-nav.layout>
    <x-slot:heading>
        {{-- Heading --}}
        <div class="flex items-center justify-between text-2xl font-bold">
            <h1 class="text-2xl font-bold text-gray-900">
                Lists
            </h1>

            {{-- Add new list button --}}
            <x-list.plus-button class="mx-4"
                id="showFormButton" />
        </div>
    </x-slot:heading>

    <div id="overlay"
        class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 backdrop-blur-sm"></div>
    <div id="createForm"
        class="relative z-50 flex hidden justify-center">
        <form action="{{ route('tasks.store') }}"
            method="POST"
            class="absolute flex w-full max-w-7xl flex-col justify-between rounded-lg border border-gray-200 bg-gray-100 p-4 shadow">
            @csrf

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">
                    <input type="text"
                        name="list_name"
                        placeholder="Untitled List"
                        class="rounded border-transparent bg-gray-300 px-4 py-2 text-gray-700 placeholder-gray-600 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                        id="list"
                        required>
                </h1>

                {{-- Close button --}}
                <x-list.close-button id="closeFormButton" />
            </div>

            <hr class="my-4">

            {{-- Task name and description --}}
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

            {{-- Submit and Delete buttons --}}
            <div class="flex items-center gap-2">
                <x-list.button type="submit"
                    value="submit"
                    size="h-9 max-w-sm"
                    class="mt-4 h-9 max-w-sm border border-transparent bg-green-500 px-4 font-medium text-white hover:bg-gray-300 focus:ring-green-500">Add</x-list.button>

                <x-list.button type="reset"
                    value="reset"
                    size="h-9 max-w-sm"
                    class="mt-4 h-9 max-w-sm border border-transparent bg-red-500 px-4 font-medium text-white hover:bg-gray-300 focus:ring-red-500">Delete</x-list.button>
            </div>
        </form>
    </div>

    @if ($lists->count() == 0)
        <p>No lists created</p>

        <a href={{ route('tasks.create') }}
            class="text-blue-500 hover:underline">Create a new list</a>
    @endif

    @foreach ($lists as $list)
        <ul class="rounded-lg border border-gray-200 bg-white ps-3 shadow">
            <li class="flex w-full items-center rounded-t-lg border-b border-gray-600 ps-3 dark:border-gray-200">

                <x-list.checkbox id="{{ $list['id'] }}"
                    is_completed="{{ $list['is_completed'] }}" />

                <a href="/tasks/{{ $list['id'] }}"
                    class="mx-2 ms-2 flex w-full flex-col py-1">
                    <div class="text-lg font-bold text-blue-500 hover:underline">
                        {{ $list['list_name'] }}

                        {{-- Display tasks count --}}
                        ({{ $list->tasks->count() }})
                    </div>
                    <p class="text-sm font-normal text-gray-500">
                        Last updated: {{ $list['updated_at'] }}
                    </p>
                </a>

                <div class="my-3 mr-4 flex space-x-1">
                    <x-list.edit-button />
                    <x-list.delete-button />
                    {{-- Delete button --}}
                    {{-- <form action="{{ route('tasks.destroy', $list->id) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this list?');">
                        @csrf
                        @method('DELETE')
                        <x-list.delete-button type="submit" />
                    </form> --}}
                </div>
            </li>
        </ul>
    @endforeach
    <div class="mt-4">
        {{-- Pagination --}}
        {{ $lists->links() }}
    </div>
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
            createForm.classList.add('hidden');
            overlay.classList.add('hidden');
            body.classList.remove('overflow-hidden'); // Allow scrolling
        };
        showFormButton.addEventListener('click', showForm);
        closeFormButton.addEventListener('click', hideForm);
        overlay.addEventListener('click', hideForm);
    });
</script>
