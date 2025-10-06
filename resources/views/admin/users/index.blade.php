<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Users Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Users Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Users Management</h1>
                <p class="text-secondary mt-2">Manage user accounts</p>
            </div>

            <!-- Add User Button -->
            <div class="mb-6">
                <a href="{{ route('admin.users.create') }}" class="bg-primary text-dark px-6 py-3 rounded-lg hover:bg-gray-200 transition font-medium inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add User
                </a>
            </div>

            <!-- Users Table -->
            <div class="bg-[#212121] border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-dark-light border-b border-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($users as $user)
                                <tr class="hover:bg-dark-light transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">
                                        @if($user->role == 1)
                                            <span class="px-2 py-1 bg-blue-500 bg-opacity-20 text-blue-400 rounded-full text-xs">User</span>
                                        @elseif($user->role == 2)
                                            <span class="px-2 py-1 bg-red-500 bg-opacity-20 text-red-400 rounded-full text-xs">Admin</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-accent hover:text-accent-hover mr-3">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @if($user->id !== auth()->id()) <!-- Prevent user from deleting themselves -->
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-400">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-800">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>