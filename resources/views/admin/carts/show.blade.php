<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('User Cart Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- User Carts Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Cart for {{ $user->name }}</h1>
                <p class="text-secondary mt-2">View all items in this user's cart</p>
            </div>

            <!-- User Info -->
            <div class="bg-[#212121] border border-gray-800 rounded-xl p-6 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-user-circle text-4xl text-primary mr-4"></i>
                    <div>
                        <h2 class="text-xl font-bold text-primary">{{ $user->name }}</h2>
                        <p class="text-secondary">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Cart Items Table -->
            <div class="bg-[#212121] border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-dark-light border-b border-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @if($cartItems->count() > 0)
                                @foreach($cartItems as $cartItem)
                                    <tr class="hover:bg-dark-light transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $cartItem->product->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $cartItem->product->category ? $cartItem->product->category->name : 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $cartItem->product->getFormattedPriceAttribute() }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $cartItem->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">
                                            Rp{{ number_format($cartItem->product->price * $cartItem->quantity, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <form action="{{ route('admin.carts.destroy', $cartItem->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this item from cart?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-400">
                                                    <i class="fas fa-trash"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-secondary">No items in this user's cart.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.carts.index') }}" class="bg-dark-light text-primary px-6 py-3 rounded-lg border border-gray-800 hover:bg-gray-800 transition font-medium inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to All Carts
                </a>
            </div>
        </div>
    </div>
</x-app-layout>