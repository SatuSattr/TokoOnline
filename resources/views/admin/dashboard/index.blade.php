<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Dashboard Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-primary">Admin Dashboard</h1>
                <p class="text-secondary mt-2">Manage your store and monitor activity</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Users Card -->
                <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 bg-opacity-20">
                            <i class="fas fa-users text-blue-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-medium text-secondary">Users</h2>
                            <p class="text-2xl font-bold text-primary">{{ $usersCount }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="mt-4 inline-block text-blue-400 hover:text-blue-300 text-sm">Manage Users</a>
                </div>

                <!-- Products Card -->
                <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500 bg-opacity-20">
                            <i class="fas fa-box text-green-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-medium text-secondary">Products</h2>
                            <p class="text-2xl font-bold text-primary">{{ $productsCount }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="mt-4 inline-block text-green-400 hover:text-green-300 text-sm">Manage Products</a>
                </div>

                <!-- Carts Card -->
                <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-500 bg-opacity-20">
                            <i class="fas fa-shopping-cart text-purple-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-lg font-medium text-secondary">Cart Items</h2>
                            <p class="text-2xl font-bold text-primary">{{ $cartsCount }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.carts.index') }}" class="mt-4 inline-block text-purple-400 hover:text-purple-300 text-sm">Manage Carts</a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                <h3 class="text-xl font-bold text-primary mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('admin.products.create') }}" class="bg-primary text-dark px-6 py-3 rounded-lg hover:bg-gray-200 transition font-medium flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i> Add New Product
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="bg-primary text-dark px-6 py-3 rounded-lg hover:bg-gray-200 transition font-medium flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i> Add New Category
                    </a>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="mt-8 bg-[#212121] border border-gray-800 rounded-xl p-6">
                <h3 class="text-xl font-bold text-primary mb-4">Recent Activity</h3>
                <p class="text-secondary">No recent activity to display.</p>
            </div>
        </div>
    </div>
</x-app-layout>