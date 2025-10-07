<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <!-- Page Header -->
    <section class="py-12 px-4 bg-dark-light">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl font-bold mb-4">All Products</h1>
            <p class="text-secondary mb-6">
                Discover our complete collection of quality products
            </p>

            <!-- Search bar -->
            <div class="max-w-2xl">
                <form action="{{ route('products.search') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Search products by name or description..."
                        class="w-full bg-dark border border-gray-800 rounded-lg px-4 py-3 pl-12 text-primary placeholder-secondary focus:outline-none focus:border-accent transition"
                        id="searchInput" />
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-secondary"></i>
                    <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary text-dark px-4 py-1 rounded-lg hover:bg-gray-200 transition font-medium">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filters Sidebar -->
                <aside class="lg:w-64 flex-shrink-0">
                    <div class="bg-dark-light border border-gray-800 rounded-xl p-6 sticky top-24">
                        <h3 class="font-bold text-lg mb-4">Filters</h3>

                        <!-- Category Filter -->
                        <div class="mb-6">
                            <h4 class="font-semibold mb-3 text-sm">Category</h4>
                            <div class="space-y-2">
                                @foreach ($categories as $category)
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" class="mr-2 accent-accent" value="{{ $category->id }}" />
                                        <span class="text-sm text-secondary">{{ $category->display_name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <h4 class="font-semibold mb-3 text-sm">Price Range</h4>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-secondary mb-1">Min ($)</label>
                                    <input type="number" min="0"
                                        class="w-full px-3 py-2 bg-dark border border-gray-800 rounded-lg text-sm focus:outline-none focus:border-accent transition"
                                        placeholder="0" disabled />
                                </div>
                                <div>
                                    <label class="block text-xs text-secondary mb-1">Max ($)</label>
                                    <input type="number" min="0"
                                        class="w-full px-3 py-2 bg-dark border border-gray-800 rounded-lg text-sm focus:outline-none focus:border-accent transition"
                                        placeholder="1000+" disabled />
                                </div>
                            </div>
                        </div>

                        <!-- Rating Filter -->
                        <div class="mb-6">
                            <h4 class="font-semibold mb-3 text-sm">Rating</h4>
                            <div class="space-y-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="mr-2 accent-accent" value="5" />
                                    <span class="text-sm text-secondary flex items-center">
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="fas fa-star text-yellow-500"></i>
                                    </span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="mr-2 accent-accent" value="4" />
                                    <span class="text-sm text-secondary flex items-center">
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="far fa-star text-yellow-500"></i>
                                    </span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="mr-2 accent-accent" value="3" />
                                    <span class="text-sm text-secondary flex items-center">
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="far fa-star text-yellow-500"></i>
                                        <i class="far fa-star text-yellow-500"></i>
                                    </span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="mr-2 accent-accent" value="2" />
                                    <span class="text-sm text-secondary flex items-center">
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="far fa-star text-yellow-500"></i>
                                        <i class="far fa-star text-yellow-500"></i>
                                        <i class="far fa-star text-yellow-500"></i>
                                    </span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="mr-2 accent-accent" value="1" />
                                    <span class="text-sm text-secondary flex items-center">
                                        <i class="fas fa-star text-yellow-500"></i>
                                        <i class="far fa-star text-yellow-500"></i>
                                        <i class="far fa-star text-yellow-500"></i>
                                        <i class="far fa-star text-yellow-500"></i>
                                        <i class="far fa-star text-yellow-500"></i>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Apply Filters Button -->
                        <button
                            class="w-full bg-accent text-white py-2 rounded-lg text-sm opacity-50 cursor-not-allowed transition mb-3"
                            disabled>
                            Apply Filters
                        </button>

                        <!-- Clear Filters Button -->
                        <button
                            class="w-full bg-dark border border-gray-800 py-2 rounded-lg text-sm opacity-50 cursor-not-allowed transition"
                            disabled>
                            Clear All Filters
                        </button>
                    </div>
                </aside>

                <!-- Products Grid -->
                <div class="flex-1">
                    <!-- Sort and View Options -->
                    <div class="flex justify-between items-center mb-6">
                        <p class="text-secondary">{{ $products->total() }} products found</p>
                        <select
                            class="bg-dark-light border border-gray-800 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-accent">
                            <option value="featured">Sort by: Featured</option>
                            <option value="price-low-high">Price: Low to High</option>
                            <option value="price-high-low">Price: High to Low</option>
                            <option value="newest">Newest</option>
                            <option value="best-rating">Best Rating</option>
                        </select>
                    </div>

                    <!-- Product Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Add to cart function
        function addToCart(productId) {
            // Check if user is authenticated
            @auth
            fetch(`/cart/add/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    updateCartCount();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding product to cart');
                });
        @else
            // Redirect to login if not authenticated
            alert('Please login to add items to cart');
            window.location.href = '/login';
        @endauth
        }
    </script>
</x-app-layout>
