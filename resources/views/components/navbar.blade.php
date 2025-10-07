<nav class="bg-dark-light border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-white">TokoOnline</a>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ url('/') }}" class="text-primary hover:text-accent transition">Home</a>
                    <a href="{{ url('/products') }}" class="text-secondary hover:text-accent transition">Products</a>
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-secondary hover:text-accent transition {{ request()->routeIs('dashboard') ? 'text-accent' : '' }}">Dashboard</a>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-secondary hover:text-accent transition {{ request()->routeIs('admin.*') ? 'text-accent' : '' }}">Admin
                                Dashboard</a>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <!-- For authenticated users, show cart icon outside dashboard -->
                    @if (!request()->routeIs('dashboard') && !request()->routeIs('admin.*'))
                        <div class="relative">
                            <a href="{{ route('cart.index') }}" class="text-secondary hover:text-primary transition">
                                <i class="fas fa-shopping-cart text-2xl"></i>
                                <span id="cart-count" 
                                    class="absolute -top-[6px] -right-1 bg-accent text-white text-[10px] rounded-full px-1 py-0.5">
                                    0
                                </span>
                            </a>
                        </div>
                    @endif

                    <!-- User Dropdown -->
                    <div class="relative" id="profile-dropdown">
                        <button id="dropdown-button" class="flex items-center text-sm focus:outline-none">
                            <span class="text-primary mr-2">{{ Auth::user()->name }}</span>
                            <i class="fas fa-user-circle text-2xl text-primary"></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdown-menu"
                            class="absolute right-0 mt-2 w-48 bg-dark-light border border-gray-800 rounded-md shadow-lg py-1 z-50 hidden">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-primary hover:bg-gray-800">Profile</a>
                            <a href="{{ route('cart.index') }}"
                                class="block px-4 py-2 text-sm text-primary hover:bg-gray-800">Cart</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-primary hover:bg-gray-800">Log
                                    Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- For guests, show cart and login -->
                    <div class="relative">
                        <a href="/login" class="text-secondary hover:text-primary transition">
                            <i class="fas fa-shopping-cart text-2xl"></i>
                            <span 
                                class="absolute -top-[6px] -right-1 bg-accent text-white text-[10px] rounded-full px-1 py-0.5">
                                0
                            </span>
                        </a>
                    </div>
                    <a href="{{ url('/login') }}"
                        class="bg-primary text-dark px-4 py-2 rounded-lg hover:bg-gray-200 transition font-medium">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.getElementById('dropdown-button');
            const dropdownMenu = document.getElementById('dropdown-menu');
            let isOpen = false;
            
            // Toggle dropdown on button click
            dropdownButton.addEventListener('click', function(e) {
                e.preventDefault();
                isOpen = !isOpen;
                dropdownMenu.classList.toggle('hidden', !isOpen);
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const dropdownContainer = document.getElementById('profile-dropdown');
                if (!dropdownContainer.contains(e.target)) {
                    isOpen = false;
                    dropdownMenu.classList.add('hidden');
                }
            });
        });
    </script>
</nav>
