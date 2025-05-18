<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
            <div class="p-6 pt-2 text-gray-900 dark:text-gray-100">
                {{-- Form Search --}}
                <form method="GET" action="{{ route('user.index') }}" class="mb-4 mt-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name or email ..."
                        class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:placeholder-gray-400 px-4 py-2">
                    <button type="submit"
                        class="px-4 py-2 bg-white text-gray-700 dark:bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                        SEARCH
                    </button>
                </form>

                {{-- Success & Danger Message --}}
                <div class="mb-4">
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
            </div>

            {{-- Table --}}
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Todo</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <td class="px-6 py-4 font-bold whitespace-nowrap dark:text-white">{{ $user->id }}</td>
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
    {{ $user->todos_count }}
    (<span class="text-green-500 dark:text-green-400">
        {{ $user->todos_completed_count }}
    </span> /
    <span class="text-blue-500 dark:text-blue-400">
        {{ $user->todos_ongoing_count }}
    </span>)
</td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-3 items-center">
                                        {{-- Admin Actions --}}
                                        @if ($user->is_admin)
                                            <form action="{{ route('user.removeadmin', $user) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-3 py-1 rounded-full bg-blue-500 text-white font-semibold hover:bg-blue-600 transition">
                                                    Remove Admin
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('user.makeadmin', $user) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-3 py-1 rounded-full bg-yellow-500 text-white font-semibold hover:bg-yellow-600 transition">
                                                    Make Admin
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Delete User --}}
                                        <form action="{{ route('user.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 text-white font-semibold px-4 py-1 rounded-full hover:bg-red-700 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No data available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-5">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
