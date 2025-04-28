<form action="{{ route('tasks.createList') }}"
    method="POST"
    id="createForm"
    class="relative flex hidden w-full max-w-7xl flex-col justify-between rounded-lg border border-gray-200 bg-gray-100 p-4 shadow">
    @csrf
    @method('POST')

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
        <x-list.close-button id="closeCreateFormButton"
            class="bg-red-500 text-white hover:bg-gray-300 focus:ring-gray-700 focus:ring-red-500" />
    </div>

    <hr class="my-4">

    <div class="flex items-start gap-2">
        {{-- Mark task as completed: --}}
        <x-list.checkbox id="createTaskCheckbox"
            name="is_completed"
            class="mt-6"
            value=1 />

        <div class="flex w-full flex-col">
            <label for="task_name">Task Name:</label>
            <input type="text"
                name="task_name"
                id="createTaskName"
                class="mb-2 h-10 w-1/2 rounded border border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">

            <label for="description">Description:</label>
            <textarea name="description"
                id="createTaskDescription"
                class="h-24 max-h-64 w-full rounded border border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"></textarea>
        </div>
    </div>

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
