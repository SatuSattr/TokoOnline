<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Pesanan Kamu</h1>
                <p class="text-secondary mt-2">Pantau status pesanan yang sudah kamu checkout.</p>
            </div>

            <div class="bg-[#212121] border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
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
                                    Harga Satuan</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Subtotal</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Dibuat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-dark-light transition">
                                    <td class="px-6 py-4 text-sm text-primary">
                                        <div class="flex items-center gap-3">
                                            <div class="w-14 h-14 flex-shrink-0">
                                                @if ($order->product?->image)
                                                    <img src="{{ $order->product->image }}" alt="{{ $order->product?->name }}"
                                                        class="w-14 h-14 object-cover rounded-md">
                                                @else
                                                    <img src="{{ asset('img/hero.jpg') }}" alt="{{ $order->product?->name }}"
                                                        class="w-14 h-14 object-cover rounded-md">
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-semibold">{{ $order->product?->name ?? 'Produk dihapus' }}</div>
                                                <div class="text-xs text-secondary">
                                                    {{ $order->shipping_method }} • {{ $order->payment_method }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-secondary">
                                        {{ $order->seller?->name ?? 'Toko' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        {{ $order->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        Rp{{ number_format($order->unit_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        Rp{{ number_format($order->subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                            @class([
                                                'bg-yellow-500/20 text-yellow-400' => $order->status === 'pending',
                                                'bg-blue-500/20 text-blue-400' => $order->status === 'paid',
                                                'bg-indigo-500/20 text-indigo-400' => $order->status === 'shipped',
                                                'bg-green-500/20 text-green-400' => $order->status === 'completed',
                                                'bg-red-500/20 text-red-400' => $order->status === 'cancelled',
                                            ])">
                                            {{ \Illuminate\Support\Str::headline($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-secondary">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-6 text-center text-secondary">
                                        Belum ada pesanan. Mulai belanja sekarang!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-800">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
