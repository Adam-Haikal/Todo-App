<form action="{{ route('tasks.update', ['id' => $list->id]) }}"
    id="updateForm"
    method="POST"
    class="relative flex hidden w-full max-w-7xl flex-col justify-between rounded-lg border border-gray-200 bg-gray-100 p-4 shadow">
    @csrf
    @method('PUT') {{-- Use PUT for updates --}}

    <div class="flex items-center justify-between">
        <h1 id="updateTaskTitle"
            class="text-2xl font-bold text-gray-900">
            {{ $list->task_name }}
        </h1>

        {{-- Close button --}}
        <x-list.close-button id="closeUpdateFormButton"
            class="bg-red-500 text-white hover:bg-red-700 focus:ring-red-700" />
    </div>

    <hr class="my-4">

    <input type="hidden"
        name="task_id"
        id="updateTaskId">

    <div class="flex items-start gap-2">
        {{-- Mark task as completed: --}}
        <x-list.checkbox name="is_completed"
            id="updateTaskCheckbox"
            class="p-2"
            class="mt-6"
            value=1 />

        <div class="flex w-full flex-col">
            <label for="task_name">Task Name</label>
            <input type="text"
                name="task_name"
                id="updateTaskName"
                placeholder="Enter Task Name"
                class="mb-2 h-10 w-1/2 rounded border border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">

            <label for="description">Description</label>
            <textarea name="description"
                id="updateTaskDescription"
                placeholder="Enter Task Description"
                class="h-24 max-h-64 w-full rounded border border-gray-300 bg-white px-3 py-2 text-gray-700 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"></textarea>
        </div>
    </div>

    {{-- Submit and Delete buttons --}}
    <div class="flex items-center gap-2">
        <x-list.button size="h-9 max-w-sm"
            type="submit"
            value="submit"
            class="mt-4 rounded-lg border border-transparent bg-green-500 px-4 font-medium text-white shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">Update</x-list.button>

        <x-list.button size="h-9 max-w-sm"
            type="reset"
            value="reset"
            class="mt-4 rounded-lg border border-transparent bg-red-500 px-4 font-medium text-white shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">Delete</x-list.button>
    </div>
</form>
