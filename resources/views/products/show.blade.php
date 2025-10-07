<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <!-- Product Detail -->
    <section class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Breadcrumb -->
            <div class="mb-8 text-sm text-secondary">
                <a href="{{ route('home') }}" class="hover:text-primary">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-primary">Products</a>
                <span class="mx-2">/</span>
                <span class="text-primary">{{ $product->name }}</span>
            </div>

            <div x-data="productDetail" class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Product Image -->
                <div>
                    <div class="bg-dark-light border border-gray-800 rounded-2xl p-8 mb-4 relative">
                        <!-- Main image display -->
                        <div class="relative overflow-hidden rounded-lg">
                            <img :src="currentImage" alt="{{ $product->name }}"
                                class="w-full h-auto rounded-lg object-cover aspect-square">
                            <!-- Navigation arrows -->
                            <button @click="prevImage"
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition"
                                :disabled="images.length <= 1">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button @click="nextImage"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition"
                                :disabled="images.length <= 1">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Thumbnails -->
                    <div class="grid grid-cols-4 gap-4">
                        <template x-for="(image, index) in images" :key="index">
                            <div class="bg-dark-light border rounded-lg p-2 cursor-pointer hover:border-accent transition"
                                :class="{ 'border-accent': index === currentImageIndex }"
                                @click="currentImageIndex = index">
                                <img :src="image" :alt="`Thumbnail ${index + 1}`"
                                    class="w-full h-auto rounded object-cover aspect-square">
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Product Info -->
                <div>
                    <div class="mb-4">
                        <span
                            class="text-accent text-sm font-medium">{{ $product->category->display_name ?? 'Category' }}</span>
                    </div>
                    <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>

                    <!-- Rating -->
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-500 mr-2">
                            <!-- Star rating -->
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= (int) $product->rating)
                                    <i class="fas fa-star"></i>
                                @elseif($i - $product->rating < 1)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-secondary text-sm">({{ number_format($product->rating, 1) }}) •
                            {{ $product->reviews }} reviews</span>
                    </div>

                    <!-- Price -->
                    <div class="mb-8">
                        <div class="flex items-baseline gap-4">
                            @if ($product->disc_price && $product->disc_price < $product->price)
                                <div class="flex items-center gap-4">
                                    <span
                                        class="text-4xl font-bold text-red-500">{{ $product->getFormattedPriceAttribute() }}</span>
                                    <span
                                        class="text-secondary line-through text-xl">{{ $product->getFormattedOriginalPriceAttribute() }}</span>
                                    <span
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm font-medium">-{{ round($product->getDiscountPercentageAttribute()) }}%
                                        OFF</span>
                                </div>
                            @else
                                <span class="text-4xl font-bold">{{ $product->getFormattedPriceAttribute() }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-lg mb-3">Description</h3>
                        <div x-ref="descriptionContainer" class="relative">
                            <p class="text-secondary leading-relaxed"
                                x-bind:class="{ 'max-h-40 overflow-hidden': !showFullDescription }"
                                x-text="descriptionText">
                            </p>
                            <div x-show="showFullDescription === false && isDescriptionOverflowing"
                                class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-[#0B0A0B] to-transparent flex items-end justify-center">
                                <button @click="showFullDescription = true"
                                    class="text-accent font-medium hover:underline translate-y-6">
                                    Read Full
                                </button>
                            </div>
                            <button x-show="showFullDescription === true" @click="showFullDescription = false"
                                class="text-accent font-medium hover:underline">
                                Show Less
                            </button>
                        </div>
                    </div>

                    <!-- Quantity (with Alpine.js for cart interaction) -->
                    <div class="mb-8">
                        <h3 class="font-semibold text-lg mb-3">Quantity</h3>
                        <div class="flex items-center space-x-4">
                            <button @click="quantity = quantity > 1 ? quantity - 1 : 1"
                                class="bg-dark-light border border-gray-800 w-10 h-10 rounded-lg hover:border-accent transition">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="text-xl font-medium w-12 text-center" x-text="quantity"></span>
                            <button @click="quantity++"
                                class="bg-dark-light border border-gray-800 w-10 h-10 rounded-lg hover:border-accent transition">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4 mb-8">
                        <button @click="addToCart({{ $product->id }})"
                            class="flex-1 bg-primary text-dark py-4 rounded-xl font-semibold hover:bg-gray-200 transition">
                            <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                        </button>
                    </div>


                </div>
            </div>

            <!-- Related Products -->
            <div class="mt-20">
                <h2 class="text-3xl font-bold mb-8">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $relatedProduct)
                        <x-product-card :product="$relatedProduct" />
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <script>
        // Initialize Alpine.js data
        document.addEventListener('alpine:init', () => {
        Alpine.data('productDetail', () => ({
                    quantity: 1,
                    currentImageIndex: 0,
                    showFullDescription: false,
                    isDescriptionOverflowing: false,
                    descriptionText: @json($product->description ?? ''),

                    init() {
                        // Check if description is overflowing after DOM is rendered
                        this.$nextTick(() => {
                            if (this.$refs.descriptionContainer) {
                                const descriptionEl = this.$refs.descriptionContainer.querySelector(
                                    'p');
                                if (descriptionEl) {
                                    this.isDescriptionOverflowing = descriptionEl.scrollHeight >
                                        descriptionEl.clientHeight;
                                }
                            }
                        });
                    },

                    get currentImage() {
                        // Get the currently selected image based on the index
                        const imageArray = this.images;
                        return imageArray[this.currentImageIndex] || @json($product->image ?: asset('img/hero.jpg'));
                    },

                    get images() {
                        // Use the images attribute from the Product model which returns all available images as an array
                        // The Product model has image, image2, image3, image4, image5 columns
                        // The getImagesAttribute method in the model already returns them as an array
                        const productImages = @json($product->images ?? []);

                        // Filter out any null or empty values and ensure we have at least the main image
                        const validImages = Array.isArray(productImages) ?
                            productImages.filter(img => img && img.trim && img.trim() !== '') : [];

                        if (validImages.length > 0) {
                            return validImages;
                        } else {
                            // Fallback to the main image if no additional images are found
                            return [@json($product->image ?: asset('img/hero.jpg'))];
                        }
                    },

                    nextImage() {
                        if (this.currentImageIndex < this.images.length - 1) {
                            this.currentImageIndex++;
                        } else {
                            this.currentImageIndex = 0; // Loop back to first image
                        }
                    },

                    prevImage() {
                        if (this.currentImageIndex > 0) {
                            this.currentImageIndex--;
                        } else {
                            this.currentImageIndex = this.images.length - 1; // Loop to last image
                        }
                    },

                    addToCart(productId) {
                        // Check if user is authenticated
                        @auth
                        fetch(`/cart/add/${productId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    quantity: this.quantity
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                alert(data.message);
                                this.updateCartCount();
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
                },

                updateCartCount() {
                    @auth
                    fetch('/cart/count', {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            const cartCountElement = document.getElementById('cart-count');
                            if (cartCountElement) {
                                cartCountElement.textContent = data.count;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                @endauth
            }
        }));
        });
    </script>
</x-app-layout>
