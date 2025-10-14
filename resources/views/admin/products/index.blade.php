<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Products Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Products Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Products Management</h1>
                <p class="text-secondary mt-2">Manage your products and inventory</p>
            </div>

            <!-- Add Product Button -->
            <div class="mb-6">
                <a href="{{ route('admin.products.create') }}"
                    class="bg-primary text-dark px-6 py-3 rounded-lg hover:bg-gray-200 transition font-medium inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add Product
                </a>
            </div>

            <!-- Products Table -->
            <div class="bg-[#212121] border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-dark-light border-b border-gray-800">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Image</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Seller</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Price</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Disc Price</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Disc %</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Rating</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach ($products as $product)
                                <tr class="hover:bg-dark-light transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($product->image)
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                                class="w-12 h-12 object-cover rounded">
                                        @else
                                            <span class="text-gray-500">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">{{ $product->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">
                                        {{ Str::limit($product->name, 30) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">
                                        {{ $product->category ? $product->category->name : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">
                                        {{ $product->seller_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">
                                        {{ $product->getFormattedPriceAttribute() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">
                                        @if ($product->disc_price)
                                            {{ $product->getFormattedDiscPriceAttribute() }}
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">
                                        @if ($product->disc_price && $product->price > 0)
                                            <span
                                                class="px-2 py-1 bg-red-500 bg-opacity-20 text-white rounded-full text-xs">{{ $product->getDiscountPercentageAttribute() }}%</span>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $product->rating)
                                                    <i class="fas fa-star text-yellow-500"></i>
                                                @elseif($i - 0.5 <= $product->rating)
                                                    <i class="fas fa-star-half-alt text-yellow-500"></i>
                                                @else
                                                    <i class="far fa-star text-yellow-500"></i>
                                                @endif
                                            @endfor
                                            <span class="ml-1">({{ $product->rating }})</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="text-accent hover:text-accent-hover mr-3">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');">
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
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
