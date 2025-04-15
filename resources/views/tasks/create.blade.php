<x-nav.layout>
    <x-slot:heading>
        Create a new task
    </x-slot:heading>

    <form action=""
        method="POST">
        @csrf

        <input type="text"
            name="list"
            placeholder="Untitled List"
            class="rounded border-transparent bg-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
            id="name"
            required>

        <hr class="my-4">


        <div class="flex items-center">
            <div class="w-4 min-w-6"> <!-- Set a fixed width for the checkbox column -->
                <input type="checkbox"
                    class="mr-4 h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-1 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700">
            </div>

            <input name="tasks"
                id="description"
                class="h-10 w-full rounded border border-gray-300 bg-white px-4 py-2 text-gray-700 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"></input>
        </div>

        <div class="flex items-center gap-2">
            <x-list.button color="bg-green-300"
                size="h-8 max-w-sm"
                type="submit"
                value="submit"
                class="mt-4 flex h-10 items-center justify-center rounded-lg border border-transparent px-4 font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">Add</x-list.button>

            <x-list.button color="bg-red-300"
                size="h-8 max-w-sm"
                type="reset"
                value="reset"
                class="mt-4 flex h-10 items-center justify-center rounded-lg border border-transparent px-4 font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">Delete</x-list.button>
        </div>
    </form>
</x-nav.layout>
