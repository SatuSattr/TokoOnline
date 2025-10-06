<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Carts Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Carts Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Carts Management</h1>
                <p class="text-secondary mt-2">View all cart items from users</p>
            </div>

            <!-- Carts Table -->
            <div class="bg-[#212121] border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-dark-light border-b border-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Date Added</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($carts as $cart)
                                <tr class="hover:bg-dark-light transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $cart->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $cart->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $cart->product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $cart->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $cart->created_at->format('M d, Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.carts.show', $cart->user->id) }}" class="text-accent hover:text-accent-hover mr-3">
                                            <i class="fas fa-eye"></i> View User Carts
                                        </a>
                                        <form action="{{ route('admin.carts.destroy', $cart->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this item from cart?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400">
                                                <i class="fas fa-trash"></i> Remove
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
                    {{ $carts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>