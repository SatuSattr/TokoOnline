<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Create Category Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Create Category</h1>
                <p class="text-secondary mt-2">Add a new category for products</p>
            </div>

            <!-- Create Category Form -->
            <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-secondary mb-2">Name</label>
                            <input type="text" name="name" id="name" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition" required>
                        </div>

                        <div>
                            <label for="display_name" class="block text-sm font-medium text-secondary mb-2">Display Name</label>
                            <input type="text" name="display_name" id="display_name" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition" required>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <button type="submit" class="bg-primary text-dark px-6 py-3 rounded-lg hover:bg-gray-200 transition font-medium">
                            Create Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="bg-dark-light text-primary px-6 py-3 rounded-lg border border-gray-800 hover:bg-gray-800 transition font-medium">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>