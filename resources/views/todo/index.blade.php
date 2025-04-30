<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
            <div class="p-6 pt-2 text-gray-900 dark:text-gray-100">
                {{-- Button Create --}}
                <div class="flex items-center justify-between mb-4">
                    <x-create-button href="{{ route('todo.create') }}" />
                </div>

                {{-- Success & Danger Message --}}
                @if (session('success'))
                    <p x-data="{ show: true }" x-show="show" x-transition
                       x-init="setTimeout(() => show = false, 5000)"
                       class="text-sm text-green-600 dark:text-green-400">
                        {{ session('success') }}
                    </p>
                @endif

                @if (session('danger'))
                    <p x-data="{ show: true }" x-show="show" x-transition
                       x-init="setTimeout(() => show = false, 5000)"
                       class="text-sm text-red-600 dark:text-red-400">
                        {{ session('danger') }}
                    </p>
                @endif
            </div>

            {{-- Table --}}
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Title</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($todos as $data)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('todo.edit', $data) }}" class="hover:underline text-sm">
                                        {{ $data->title }}
                                    </a>
                                </td>

                                <td class="px-6 py-4">
                                    @if (!$data->is_done)
                                        <span class="inline-block bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full dark:bg-blue-500 dark:text-white">
                                            Ongoing
                                        </span>
                                    @else
                                        <span class="inline-block bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full dark:bg-green-500 dark:text-white">
                                            Completed
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        @if (!$data->is_done)
                                            <form action="{{ route('todo.complete', $data) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 dark:text-green-400 hover:underline">
                                                    Complete
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('todo.uncomplete', $data) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-blue-600 dark:text-blue-400 hover:underline">
                                                    Uncomplete
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Delete Button --}}
                                        <form action="{{ route('todo.destroy', $data) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this todo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-full hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No data available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Delete All Completed Button --}}
            <div class="flex justify-end mt-4 px-6 pb-6">
                <form action="{{ route('todo.destroyCompleted') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete all completed tasks?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition">
                        DELETE ALL COMPLETED TASK
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
