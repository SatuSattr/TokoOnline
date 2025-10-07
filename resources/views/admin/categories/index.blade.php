<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Categories Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Categories Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Categories Management</h1>
                <p class="text-secondary mt-2">Manage product categories</p>
            </div>

            <!-- Add Category Button -->
            <div class="mb-6">
                <a href="{{ route('admin.categories.create') }}" class="bg-primary text-dark px-6 py-3 rounded-lg hover:bg-gray-200 transition font-medium inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add Category
                </a>
            </div>

            <!-- Categories Table -->
            <div class="bg-[#212121] border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-dark-light border-b border-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Display Name</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Product Count</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($categories as $category)
                                <tr class="hover:bg-dark-light transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $category->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $category->display_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $category->products_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-accent hover:text-accent-hover mr-3">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-800">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>