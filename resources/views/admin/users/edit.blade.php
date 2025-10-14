<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Edit User Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Edit User</h1>
                <p class="text-secondary mt-2">Update user account information</p>
            </div>

            <!-- Edit User Form -->
            <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-secondary mb-2">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-secondary mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition" required>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-secondary mb-2">New Password (Optional)</label>
                            <input type="password" name="password" id="password" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition">
                            <p class="text-xs text-secondary mt-1">Leave blank to keep current password</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-secondary mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition">
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-secondary mb-2">Role</label>
                            <select name="role" id="role" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition" required>
                                <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>User</option>
                                <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>Seller</option>
                                <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <button type="submit" class="bg-primary text-dark px-6 py-3 rounded-lg hover:bg-gray-200 transition font-medium">
                            Update User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="bg-dark-light text-primary px-6 py-3 rounded-lg border border-gray-800 hover:bg-gray-800 transition font-medium">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
