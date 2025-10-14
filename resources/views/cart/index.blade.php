<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div x-data="cartApp()" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cart Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Your Shopping Cart</h1>
                <p class="text-secondary mt-2">Review and manage items in your cart</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-[#212121] border border-gray-800 rounded-xl overflow-hidden">
                        @if ($cartItems->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="bg-dark-light border-b border-gray-800">
                                        <tr>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                                <input type="checkbox" @change="toggleSelectAll"
                                                    class="rounded text-accent focus:ring-accent">
                                            </th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                                Product</th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                                Price</th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                                Quantity</th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                                Total</th>
                                            <th
                                                class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                        @foreach ($cartItems as $item)
                                            <tr class="hover:bg-dark-light transition">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <input type="checkbox"
                                                        :checked="selectedItems.includes({{ $item->id }})"
                                                        @change="toggleItemSelection({{ $item->id }}, {{ $item->product->disc_price ?: $item->product->price }})"
                                                        class="cart-item-checkbox rounded text-accent focus:ring-accent"
                                                        value="{{ $item->id }}"
                                                        data-price="{{ $item->product->disc_price ?: $item->product->price }}"
                                                        data-quantity="{{ $item->quantity }}">
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-start">
                                                        <div class="flex-shrink-0 h-16 w-16">
                                                            @if ($item->product->image)
                                                                <img class="h-16 w-16 rounded-md object-cover"
                                                                    src="{{ $item->product->image }}"
                                                                    alt="{{ $item->product->name }}">
                                                            @else
                                                                <img class="h-16 w-16 rounded-md object-cover"
                                                                    src="{{ asset('img/hero.jpg') }}"
                                                                    alt="{{ $item->product->name }}">
                                                            @endif
                                                        </div>
                                                        <div class="ml-4 min-w-0">
                                                            <div class="text-sm font-medium text-primary break-words">
                                                                {{ $item->product->name }}</div>
                                                            <div class="text-sm text-secondary">
                                                                {{ $item->product->getCategoryDisplayNameAttribute() }}
                                                            </div>
                                                            <div class="text-xs text-secondary mt-1">
                                                                Seller: {{ $item->product->seller_name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-primary">
                                                    {{ $item->product->getFormattedOriginalPriceAttribute() }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <div
                                                        class="flex items-center rounded-lg overflow-hidden border border-gray-800 bg-dark-light">
                                                        <button type="button"
                                                            @click="decreaseQuantity({{ $item->id }}, {{ $item->product->disc_price ?: $item->product->price }})"
                                                            class="decrease-qty-btn cursor-pointer text-primary px-3 py-1">-</button>

                                                        <p x-text="getQuantity({{ $item->id }})"
                                                            class="w-5 text-center bg-dark-light cursor-default text-primary py-1">
                                                            {{ $item->quantity }}</p>

                                                        <button type="button"
                                                            @click="increaseQuantity({{ $item->id }}, {{ $item->product->disc_price ?: $item->product->price }})"
                                                            class="increase-qty-btn cursor-pointer text-primary px-3 py-1">+</button>
                                                    </div>

                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-primary"
                                                    x-text="formatCurrency(getTotal({{ $item->id }}))">
                                                    @php
                                                        $price = $item->product->disc_price ?: $item->product->price;
                                                        $total = $price * $item->quantity;
                                                    @endphp
                                                    Rp{{ number_format($total, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                                    <button @click="removeFromCart({{ $item->id }})"
                                                        class="text-red-500  hover:text-red-400">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-8 text-center">
                                <i class="fas fa-shopping-cart text-5xl text-secondary mb-4"></i>
                                <h3 class="text-xl font-medium text-primary mb-2">Your cart is empty</h3>
                                <p class="text-secondary mb-6">Looks like you haven't added any items to your cart yet
                                </p>
                                <a href="{{ url('/') }}"
                                    class="bg-primary text-dark px-6 py-3 rounded-lg hover:bg-gray-200 transition font-medium inline-flex items-center">
                                    <i class="fas fa-shopping-bag mr-2"></i> Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-xl font-bold text-primary">Order Summary</h2>
                        </div>

                        <div class="text-xs text-secondary mb-2">
                            <span x-text="selectedCount"></span> selected • Prices include tax where applicable
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center gap-4 text-sm">
                                <div class="flex-1">
                                    <div class="flex justify-between gap-2">
                                        <span class="text-secondary">Subtotal</span>
                                        <span class="text-primary" x-text="formatCurrency(subtotal)"></span>
                                    </div>
                                    <div class="flex justify-between gap-2">
                                        <span class="text-secondary">Discount</span>
                                        <span class="text-primary" x-text="formatCurrency(totalDiscount)"></span>
                                    </div>
                                    <div class="flex justify-between gap-2">
                                        <span class="text-secondary">Shipping</span>
                                        <span class="text-primary" x-text="formatCurrency(shippingFee)"></span>
                                    </div>
                                    <div class="flex justify-between gap-2">
                                        <span class="text-secondary">Tax</span>
                                        <span class="text-primary" x-text="formatCurrency(tax)"></span>
                                    </div>
                                </div>
                            </div>

                            <div id="savings-note" class="text-xs text-secondary" x-show="totalDiscount > 0">
                                You save <span class="text-primary" x-text="formatCurrency(totalDiscount)"></span> with
                                discount.
                            </div>
                        </div>

                        <div class="flex justify-between items-baseline mt-3">
                            <span class="text-primary font-bold">Total</span>
                            <span class="text-primary font-bold text-lg" x-text="formatCurrency(total)"></span>
                        </div>
                    </div>


                    <div class="mt-4 bg-[#212121] border border-gray-800 rounded-xl p-6">
                        <!-- Checkout Form Fields -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-primary mb-4">Delivery Information</h3>

                            <!-- Address Field -->
                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-secondary mb-2">
                                    Delivery Address <span class="text-red-500">*</span>
                                </label>
                                <textarea id="address" x-model="shippingAddress"
                                    class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition"
                                    placeholder="Enter your complete delivery address" rows="3"></textarea>
                            </div>

                            <!-- Shipping Method -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-secondary mb-2">
                                    Shipping Method <span class="text-red-500">*</span>
                                </label>
                                <select x-model="shippingMethod" @change="updateShippingFee()"
                                    class="w-full bg-dark-light border border-gray-800 rounded-lg px-3 py-2 text-sm text-primary focus:outline-none focus:border-accent">
                                    <option value="" disabled selected>Select a shipping method</option>
                                    <option value="JNE">JNE - Rp 15,000</option>
                                    <option value="JNT">JNT - Rp 12,000</option>
                                    <option value="POS">POS - Rp 10,000</option>
                                    <option value="Ninja Express">Ninja Express - Rp 13,000</option>
                                </select>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-secondary mb-2">
                                    Payment Method <span class="text-red-500">*</span>
                                </label>
                                <select x-model="paymentMethod"
                                    class="w-full bg-dark-light border border-gray-800 rounded-lg px-3 py-2 text-sm text-primary focus:outline-none focus:border-accent">
                                    <option value="" disabled selected>Select a payment method</option>
                                    <option value="Qris">QRIS</option>
                                    <option value="Transfer Bank">Bank Transfer</option>
                                    <option value="COD">Cash on Delivery (COD)</option>
                                </select>
                            </div>

                            <!-- Additional Notes -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-secondary mb-2">
                                    Order Notes
                                </label>
                                <textarea x-model="notes"
                                    class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition"
                                    placeholder="Add notes for the seller (optional)" rows="2"></textarea>
                            </div>
                        </div>

                        <button @click="proceedToCheckout" :disabled="selectedCount === 0 || isSubmitting"
                            :class="{
                                'bg-primary/70 cursor-not-allowed': selectedCount === 0 || isSubmitting,
                                'bg-primary hover:bg-gray-200': selectedCount > 0 && !isSubmitting
                            }"
                            class="w-full text-dark px-6 py-4 rounded-lg transition font-medium">
                            <span x-show="selectedCount === 0">Select Items to Checkout</span>
                            <span x-show="selectedCount > 0 && !isSubmitting"
                                x-text="`Checkout (${selectedCount} item${selectedCount > 1 ? 's' : ''})`"></span>
                            <span x-show="isSubmitting">Processing...</span>
                        </button>
                        <div class="flex items-center justify-between mt-4">
                            <button @click="clearSelection"
                                class="text-xs text-secondary hover:text-primary underline">
                                Clear selection
                            </button>
                            <a href="{{ url('/') }}"
                                class="text-xs text-secondary hover:text-primary underline">
                                Continue shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cartApp() {
            return {
                selectedItems: [],
                shippingAddress: '',
                notes: '',
                isSubmitting: false,
                shippingFee: 0,
                shippingMethod: '',
                paymentMethod: '',
                cartItemIds: [
                    @foreach ($cartItems as $item)
                        {{ $item->id }},
                    @endforeach
                ],

                init() {
                    // Initialize selected items with all items checked by default
                    this.selectedItems = [...this.cartItemIds];
                },

                get selectedCount() {
                    return this.selectedItems.length;
                },

                get subtotal() {
                    let subtotal = 0;
                    // Calculate subtotal based on selected items
                    @foreach ($cartItems as $item)
                        if (this.selectedItems.includes({{ $item->id }})) {
                            const price =
                                {{ $item->product->disc_price ?: $item->product->price }}; // Use discount price if available
                            const qty = this.getQuantity({{ $item->id }}); // Use the dynamic quantity
                            subtotal += price * qty;
                        }
                    @endforeach
                    return subtotal;
                },

                get totalDiscount() {
                    let totalDiscount = 0;
                    @foreach ($cartItems as $item)
                        if (this.selectedItems.includes({{ $item->id }})) {
                            const originalPrice = {{ $item->product->price }};
                            const discountedPrice = {{ $item->product->disc_price ?: $item->product->price }};
                            const qty = this.getQuantity({{ $item->id }});
                            if (originalPrice > discountedPrice) {
                                totalDiscount += (originalPrice - discountedPrice) * qty;
                            }
                        }
                    @endforeach
                    return totalDiscount;
                },

                get tax() {
                    return this.subtotal * 0.004; // 10% tax
                },

                get total() {
                    return this.subtotal + this.tax + this.shippingFee;
                },

                quantities: {
                    @foreach ($cartItems as $item)
                        {{ $item->id }}: {{ $item->quantity }},
                    @endforeach
                },

                getQuantity(id) {
                    return this.quantities[id] || 1;
                },

                getTotal(id) {
                    const items = {
                        @foreach ($cartItems as $item)
                            {{ $item->id }}: {{ $item->product->disc_price ?: $item->product->price }},
                        @endforeach
                    };
                    const price = items[id] || 0;
                    return price * this.getQuantity(id);
                },

                toggleItemSelection(id, price) {
                    if (this.selectedItems.includes(id)) {
                        this.selectedItems = this.selectedItems.filter(item => item !== id);
                    } else {
                        this.selectedItems.push(id);
                    }
                },

                toggleSelectAll() {
                    if (this.selectedItems.length === this.cartItemIds.length) {
                        this.selectedItems = [];
                    } else {
                        this.selectedItems = [...this.cartItemIds];
                    }
                },

                increaseQuantity(id, price) {
                    this.quantities[id]++;
                    this.updateQuantity(id, this.quantities[id]);
                },

                decreaseQuantity(id, price) {
                    if (this.quantities[id] > 1) {
                        this.quantities[id]--;
                        this.updateQuantity(id, this.quantities[id]);
                    }
                },

                updateQuantity(cartId, quantity) {
                    fetch(`/cart/update/${cartId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // The quantities are already updated in Alpine data, so UI will react automatically
                            this.quantities[cartId] = quantity;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error updating cart');
                        });
                },

                updateShippingFee() {
                    const shippingCosts = {
                        'JNE': 15000,
                        'JNT': 12000,
                        'POS': 10000,
                        'Ninja Express': 13000
                    };
                    this.shippingFee = shippingCosts[this.shippingMethod] || 0;
                },

                removeFromCart(cartId) {
                    if (confirm('Are you sure you want to remove this item from your cart?')) {
                        fetch(`/cart/remove/${cartId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content'),
                                    'Accept': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Remove the row from the table and update the summary
                                const row = document.querySelector(`tr:has(input[value="${cartId}"])`);
                                if (row) {
                                    row.remove();
                                }
                                // Remove from local collections
                                this.cartItemIds = this.cartItemIds.filter(item => item !== cartId);
                                this.selectedItems = this.selectedItems.filter(item => item !== cartId);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error removing item from cart');
                            });
                    }
                },

                clearSelection() {
                    this.selectedItems = [];
                },

                proceedToCheckout() {
                    if (this.isSubmitting) {
                        return;
                    }

                    if (this.selectedCount === 0) {
                        alert('Please select at least one item to checkout.');
                        return;
                    }

                    if (!this.shippingAddress.trim()) {
                        alert('Please enter your delivery address.');
                        return;
                    }

                    if (!this.shippingMethod) {
                        alert('Please select a shipping method.');
                        return;
                    }

                    if (!this.paymentMethod) {
                        alert('Please select a payment method.');
                        return;
                    }

                    this.isSubmitting = true;

                    fetch('/checkout', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                            },
                            body: JSON.stringify({
                                items: this.selectedItems,
                                shipping_address: this.shippingAddress.trim(),
                                shipping_method: this.shippingMethod,
                                payment_method: this.paymentMethod,
                                notes: this.notes.trim() || null,
                            })
                        })
                        .then(async response => {
                            const data = await response.json().catch(() => ({}));
                            if (!response.ok) {
                                throw new Error(data.message || 'Checkout gagal. Silakan coba lagi.');
                            }
                            return data;
                        })
                        .then(data => {
                            const redirectUrl = data.redirect_url || '/orders';
                            window.location.href = redirectUrl;
                        })
                        .catch(error => {
                            this.isSubmitting = false;
                            alert(error.message);
                        });
                },

                formatCurrency(amount) {
                    return 'Rp' + amount.toLocaleString('id-ID', {
                        maximumFractionDigits: 0
                    });
                }
            }
        }

        @auth
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });
        @endauth
    </script>
</x-app-layout>
