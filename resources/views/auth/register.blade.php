<x-guest-layout>
    <!-- Register Section -->
    <section class="py-10 px-4">
        <div class="max-w-md mx-auto">
            <!-- Register Form -->
            <div class="bg-dark-light border border-gray-800 rounded-2xl p-8">
                <h2 class="text-3xl font-bold mb-2">Create account</h2>
                <p class="text-secondary mb-8">Join us and start shopping today</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            autocomplete="name" placeholder="John Doe"
                            class="w-full px-4 py-3 bg-dark border border-gray-800 rounded-lg focus:outline-none focus:border-accent transition @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="username" placeholder="your@email.com"
                            class="w-full px-4 py-3 bg-dark border border-gray-800 rounded-lg focus:outline-none focus:border-accent transition @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <input type="password" name="password" required autocomplete="new-password"
                                placeholder="Create a password"
                                class="w-full px-4 py-3 bg-dark border border-gray-800 rounded-lg focus:outline-none focus:border-accent transition @error('password') border-red-500 @enderror">
                            <button type="button"
                                class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 text-secondary hover:text-primary">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Confirm Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Confirm your password"
                                class="w-full px-4 py-3 bg-dark border border-gray-800 rounded-lg focus:outline-none focus:border-accent transition">
                            <button type="button"
                                class="toggle-password-confirm absolute right-4 top-1/2 -translate-y-1/2 text-secondary hover:text-primary">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" name="terms" class="mr-2 mt-1 accent-accent">
                            <span class="text-sm text-secondary">
                                I agree to the <a href="#" class="text-accent hover:underline">Terms of
                                    Service</a> and <a href="#" class="text-accent hover:underline">Privacy
                                    Policy</a>
                            </span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-primary text-dark py-3 rounded-lg font-semibold hover:bg-gray-200 transition mb-6">
                        Create Account
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
                        <button type="button"
                            class="flex items-center justify-center py-3 bg-dark border border-gray-800 rounded-lg hover:border-accent transition">
                            <i class="fab fa-google mr-2"></i> Google
                        </button>
                        <button type="button"
                            class="flex items-center justify-center py-3 bg-dark border border-gray-800 rounded-lg hover:border-accent transition">
                            <i class="fab fa-facebook mr-2"></i> Facebook
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-secondary">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-accent font-medium hover:underline">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password visibility toggle for password field
            const togglePassword = document.querySelectorAll('.toggle-password');
            togglePassword.forEach(button => {
                let passwordVisible = false;

                button.addEventListener('click', function() {
                    const passwordInput = this.closest('.relative').querySelector(
                        'input[type="password"]');
                    passwordVisible = !passwordVisible;
                    passwordInput.type = passwordVisible ? 'text' : 'password';
                    this.innerHTML = passwordVisible ? '<i class="fas fa-eye-slash"></i>' :
                        '<i class="fas fa-eye"></i>';
                });
            });

            // Password visibility toggle for confirm password field
            const togglePasswordConfirm = document.querySelectorAll('.toggle-password-confirm');
            togglePasswordConfirm.forEach(button => {
                let passwordConfirmVisible = false;

                button.addEventListener('click', function() {
                    const passwordInput = this.closest('.relative').querySelector(
                        'input[type="password"]');
                    passwordConfirmVisible = !passwordConfirmVisible;
                    passwordInput.type = passwordConfirmVisible ? 'text' : 'password';
                    this.innerHTML = passwordConfirmVisible ? '<i class="fas fa-eye-slash"></i>' :
                        '<i class="fas fa-eye"></i>';
                });
            });
        });
    </script>
</x-guest-layout>
