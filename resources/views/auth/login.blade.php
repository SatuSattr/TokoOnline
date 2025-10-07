<x-guest-layout>
    <!-- Login Section -->
    <section class="py-10 px-4">
        <div class="max-w-md mx-auto">
            <!-- Login Form -->
            <div class="bg-dark-light border border-gray-800 rounded-2xl p-8">
                <h2 class="text-3xl font-bold mb-2">Welcome back</h2>
                <p class="text-secondary mb-8">Login to your account to continue shopping</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input 
                            type="email" 
                            name="email"
                            value="{{ old('email') }}"
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="your@email.com"
                            class="w-full px-4 py-3 bg-dark border border-gray-800 rounded-lg focus:outline-none focus:border-accent transition @error('email') border-red-500 @enderror"
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                name="password"
                                required 
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="w-full px-4 py-3 bg-dark border border-gray-800 rounded-lg focus:outline-none focus:border-accent transition @error('password') border-red-500 @enderror"
                            >
                            <button type="button" class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 text-secondary hover:text-primary">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="mr-2 accent-accent">
                            <span class="text-sm text-secondary">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-accent hover:underline">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-primary text-dark py-3 rounded-lg font-semibold hover:bg-gray-200 transition mb-6">
                        Login
                    </button>

                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-800"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-dark-light text-secondary">Or continue with</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" class="flex items-center justify-center py-3 bg-dark border border-gray-800 rounded-lg hover:border-accent transition">
                            <i class="fab fa-google mr-2"></i> Google
                        </button>
                        <button type="button" class="flex items-center justify-center py-3 bg-dark border border-gray-800 rounded-lg hover:border-accent transition">
                            <i class="fab fa-facebook mr-2"></i> Facebook
                        </button>
                    </div>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-secondary">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-accent font-medium hover:underline">Register</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.querySelector('input[name="password"]');
            let passwordVisible = false;
            
            togglePassword.addEventListener('click', function() {
                passwordVisible = !passwordVisible;
                passwordInput.type = passwordVisible ? 'text' : 'password';
                this.innerHTML = passwordVisible ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
            });
        });
    </script>
</x-guest-layout>