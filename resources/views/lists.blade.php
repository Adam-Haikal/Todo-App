<x-nav.layout>
    <x-slot:heading>
        Lists
    </x-slot:heading>

    @if ($lists->count() == 0)
        <p>No lists created</p>

        <a href="/tasks/create"
            class="text-blue-500 hover:underline">Create a new list</a>
    @endif

    @foreach ($lists as $list)
        <ul class="w-full rounded-lg border border-gray-200 bg-gray-300 ps-3">
            <li class="flex w-full items-center rounded-t-lg border-b border-gray-600 ps-3 dark:border-gray-200">

                <a href="/tasks/{{ $list['id'] }}"
                    class="mx-2 ms-2 flex w-full flex-col py-1">
                    <div class="text-lg font-bold text-blue-500 hover:underline">
                        {{ $list['name'] }}

                        {{-- Display tasks count --}}
                        ({{ $list->tasks->count() }})
                    </div>
                    <p class="text-sm font-normal text-gray-500">
                        Last updated: {{ $list['updated_at'] }}
                    </p>
                </a>

                <form action="/"
                    method="POST"
                    class="my-3 mr-4 flex space-x-1">
                    @csrf

                    <x-list.edit-button/>
                    <x-list.delete-button/>
                </form>
                
            </li>
        </ul>
    @endforeach
</x-nav.layout>
