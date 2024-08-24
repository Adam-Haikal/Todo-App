<div class="min-w-6 w-4"> <!-- Set a fixed width for the checkbox column -->
    <input type="checkbox"
        id="{{ $task['id'] }}"
        {{ $task['is_completed'] ? 'checked' : '' }}
        class="mr-4 h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-1 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-700">
</div>
