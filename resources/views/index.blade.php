<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TokoOnline - Belanja Online Terpercaya</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js -->
</head>

<body class="bg-dark text-primary">
    <!-- Navigation -->
    <x-navbar />

    <!-- Hero Section with Search -->
    <section class="py-20 px-4 relative">
        <div class="absolute inset-0 bg-cover bg-center brightness-[14%]"
            style="background-image: url('{{ asset('img/hero.jpg') }}');">></div>
        <div class="relative max-w-4xl mx-auto text-center z-10">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                Find the Best<br />
                Product for You
            </h1>
            <p class="text-secondary text-lg mb-10 max-w-2xl mx-auto">
                Shop online easily and safely. Thousands of quality products at the
                best prices await you.
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <form action="{{ route('products.search') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Search product, category, or brand..."
                        class="w-full px-6 py-4 bg-dark-light border border-gray-800 rounded-xl text-primary placeholder-secondary focus:outline-none focus:border-accent transition"
                        id="searchInput" />
                    <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary text-dark px-6 py-2 rounded-lg hover:bg-gray-200 transition font-medium">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </form>
            </div>

            <!-- Quick Categories -->
            <div class="flex flex-wrap justify-center gap-3 mt-8">
                @foreach ($categories as $category)
                    <button
                        class="px-4 py-2 bg-dark-light border border-gray-800 rounded-lg hover:border-accent transition text-sm"
                        onclick="window.location.href = `products.html?category={{ $category->name }}`">{{ $category->display_name }}</button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 px-4 bg-dark-light">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-3xl font-bold">Featured Products</h2>
                <a href="products.html" class="text-accent hover:underline">View All <i
                        class="fas fa-arrow-right ml-1"></i></a>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-light border-t border-gray-800 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">TokoOnline</h3>
                    <p class="text-secondary text-sm">
                        Your trusted online shopping destination for quality products at
                        the best prices.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Shop</h4>
                    <ul class="space-y-2 text-secondary text-sm">
                        <li>
                            <a href="#" class="hover:text-primary transition">All Products</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-primary transition">Categories</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-primary transition">Deals</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-primary transition">New Arrivals</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-secondary text-sm">
                        <li>
                            <a href="#" class="hover:text-primary transition">Help Center</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-primary transition">Shipping Info</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-primary transition">Returns</a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-primary transition">Contact Us</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-secondary hover:text-primary transition"><i
                                class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-secondary hover:text-primary transition"><i
                                class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-secondary hover:text-primary transition"><i
                                class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-secondary hover:text-primary transition"><i
                                class="fab fa-youtube text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-secondary text-sm">
                <p>&copy; 2025 TokoOnline. All rights reserved.</p>
            </div>
        </div>
    </footer>

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
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding product to cart');
                });
            @else
                // Redirect to login if not authenticated
                window.location.href = '/login';
            @endauth
        }
    </script>
</body>

</html>
