<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-primary">Checkout Summary</h1>
                    <p class="text-secondary mt-2">Checkout diproses dari halaman keranjang. Pilih item yang ingin kamu
                        beli lalu lanjutkan checkout di sana untuk mengisi alamat dan metode pembayaran.</p>
                </div>

                <div class="overflow-x-auto border border-gray-800 rounded-xl">
                    <table class="min-w-full">
                        <thead class="bg-dark-light border-b border-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Produk</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Seller</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Qty</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse ($cartItems as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        {{ $item->product->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-secondary">
                                        {{ $item->product->seller_name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        Rp{{ number_format($item->product->disc_price && $item->product->disc_price < $item->product->price ? $item->product->disc_price : $item->product->price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-6 text-center text-secondary">
                                        Keranjang kamu kosong. Yuk belanja dulu!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('cart.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-primary text-dark rounded-lg font-medium hover:bg-gray-200 transition">
                        Kembali ke Keranjang
                    </a>
                    <a href="{{ route('orders.index') }}"
                        class="text-secondary hover:text-primary underline text-sm">
                        Lihat pesanan kamu
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
