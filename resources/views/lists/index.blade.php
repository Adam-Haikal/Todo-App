<x-nav.layout>
    <x-slot:heading>
        {{-- Heading --}}
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">
                Lists
            </h1>

            {{-- Add new list button --}}
            <x-list.plus-button class="mx-4"
                id="showFormButton"
                name="showFormButtons" />
        </div>
    </x-slot:heading>

    {{-- Overlay and Add List forms --}}
    <div id="overlay"
        class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 backdrop-blur-sm"></div>

    <div
        class="fixed left-1/2 top-1/2 z-50 flex w-full max-w-md -translate-x-1/2 -translate-y-1/2 items-center justify-center md:max-w-7xl">
        @include('lists.create-list-form')
        @include('lists.update-list-form')
    </div>

    @if ($lists->count() == 0)
        <p>No lists created</p>

        <span name="showFormButtons"
            class="cursor-pointer text-blue-500 hover:underline">Create a new list
        </span>
    @endif

    {{-- Delete button --}}
    <form action=""
        method="POST"
        onsubmit="return confirm('Are you sure you want to delete the selected lists?');">
        @csrf
        @method('DELETE')

        {{-- Button to toggle the visibility of checkboxes and delete button --}}
        @if ($lists->count() > 0)
            <div class="my-2 flex items-center">
                <button type="button"
                    id="ShowDeleteModeButton"
                    class="h-9 rounded-lg bg-red-600 px-4 text-white hover:bg-red-700 focus:ring-red-700">
                    Delete List
                </button>

                {{-- Button to enable checkbox to delete multiple lists --}}
                <x-list.delete-button type="submit"
                    id="deleteButton"
                    class="hidden rounded-l-lg rounded-r-none" />
                <x-list.close-button id="closeDeleteModeButton"
                    class="hidden h-9 w-9 rounded-l-none rounded-r-lg bg-gray-400 text-white hover:bg-gray-500 focus:ring-gray-700" />
            </div>
        @endif

        @foreach ($lists as $list)
            <div class="flex items-center">

                {{-- Checkbox for selecting multiple tasks for delete --}}
                <input type="checkbox"
                    name="delete_list_ids[]"
                    class="mx-2 hidden h-5 w-5 border-gray-300 text-red-600 focus:ring-red-500"
                    value="{{ $list['id'] }}">

                {{-- Display lists --}}
                <ul class="w-full rounded-lg border border-gray-200 bg-white shadow">
                    <li class="flex items-center rounded-t-lg border-b border-gray-200 ps-2">

                        {{-- Checkbox for marking task as completed --}}
                        {{-- <x-list.checkbox id="{{ $list['id'] }}"
                            is_completed="{{ $list['is_completed'] }}"
                            class="p-2"
                            name="is_completed" /> --}}

                        <a href="{{ route('tasks.index', $list['id']) }}"
                            {{-- class="flex w-full flex-col py-1" --}}
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
                            <x-list.edit-button name="edit-button"
                                data-list="{{ json_encode($list) }}" />
                        </div>
                    </li>
                </ul>
            </div>
        @endforeach

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $lists->links() }}
        </div>
    </form>
</x-nav.layout>

<script src="{{ asset('js/toggleForm.js') }}"></script>
<script src="{{ asset('js/updateList.js') }}"></script>
<script src="{{ asset('js/toggleDeleteButton.js') }}"></script>
