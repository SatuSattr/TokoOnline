<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-primary">Halo, {{ auth()->user()->name }}</h1>
                    <p class="text-secondary mt-2">Kelola produk dan pantau pesanan pelanggan kamu di sini.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('seller.products.create') }}"
                        class="inline-flex items-center px-5 py-3 bg-primary text-dark rounded-lg font-medium hover:bg-gray-200 transition">
                        <i class="fas fa-plus mr-2"></i> Tambah Produk
                    </a>
                    <a href="{{ route('seller.orders.index') }}"
                        class="inline-flex items-center px-5 py-3 bg-dark-light border border-gray-800 text-primary rounded-lg font-medium hover:bg-gray-800 transition">
                        Lihat Pesanan
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-[#212121] border border-gray-800 rounded-xl p-5">
                    <div class="text-secondary text-sm mb-1">Produk Aktif</div>
                    <div class="text-3xl font-bold text-primary">{{ $productCount }}</div>
                </div>
                <div class="bg-[#212121] border border-gray-800 rounded-xl p-5">
                    <div class="text-secondary text-sm mb-1">Pesanan Pending</div>
                    <div class="text-3xl font-bold text-primary">{{ $pendingOrders }}</div>
                </div>
                <div class="bg-[#212121] border border-gray-800 rounded-xl p-5">
                    <div class="text-secondary text-sm mb-1">Pesanan Selesai</div>
                    <div class="text-3xl font-bold text-primary">{{ $completedOrders }}</div>
                </div>
                <div class="bg-[#212121] border border-gray-800 rounded-xl p-5">
                    <div class="text-secondary text-sm mb-1">Total Pendapatan</div>
                    <div class="text-3xl font-bold text-primary">
                        Rp{{ number_format($totalRevenue, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-primary">Produk Terbaru</h2>
                        <a href="{{ route('seller.products.index') }}"
                            class="text-sm text-secondary hover:text-primary">Lihat semua</a>
                    </div>

                    @forelse ($recentProducts as $product)
                        <div class="flex items-start gap-4 py-3 border-b border-gray-800 last:border-b-0">
                            <div class="w-14 h-14 flex-shrink-0">
                                @if ($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                        class="w-14 h-14 object-cover rounded-md"
                                        onerror="this.src='{{ asset('img/hero.jpg') }}'; this.onerror=null;">
                                @else
                                    <img src="{{ asset('img/hero.jpg') }}" alt="{{ $product->name }}"
                                        class="w-14 h-14 object-cover rounded-md">
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="text-primary font-semibold">{{ $product->name }}</div>
                                <div class="text-xs text-secondary">
                                    {{ $product->category?->display_name ?? $product->category?->name ?? '-' }} •
                                    {{ $product->created_at->diffForHumans() }}
                                </div>
                                <div class="mt-2 text-sm text-secondary">
                                    Harga: {{ $product->formatted_price }}
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('seller.products.edit', $product->id) }}"
                                    class="text-sm text-accent hover:text-accent-hover">Edit</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-secondary text-sm">
                            Belum ada produk. <a href="{{ route('seller.products.create') }}"
                                class="text-primary hover:underline">Tambah sekarang</a>.
                        </div>
                    @endforelse
                </div>

                <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-primary">Pesanan Terbaru</h2>
                        <a href="{{ route('seller.orders.index') }}"
                            class="text-sm text-secondary hover:text-primary">Kelola pesanan</a>
                    </div>

                    @forelse ($recentOrders as $order)
                        <div class="py-3 border-b border-gray-800 last:border-b-0">
                            <div class="flex justify-between text-sm text-primary">
                                <span>{{ $order->product?->name ?? 'Produk dihapus' }}</span>
                                <span class="text-secondary">{{ $order->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="text-xs text-secondary mt-1">
                                Qty: {{ $order->quantity }} •
                                Rp{{ number_format($order->subtotal, 0, ',', '.') }} •
                                {{ \Illuminate\Support\Str::headline($order->status) }}
                            </div>
                            <div class="text-xs text-secondary mt-1">
                                Pembeli: {{ $order->buyer?->name ?? 'User dihapus' }}
                            </div>
                        </div>
                    @empty
                        <div class="text-secondary text-sm">
                            Belum ada pesanan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
