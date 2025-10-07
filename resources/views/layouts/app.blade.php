<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-dark text-primary">
        <x-navbar />


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-dark-light border-t border-gray-800 py-12 px-4 ">
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
                                <a href="{{ route('home') }}" class="hover:text-primary transition">All Products</a>
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
    </div>
</body>

</html>
