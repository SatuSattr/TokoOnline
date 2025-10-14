<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-primary">Pesanan Masuk</h1>
                    <p class="text-secondary mt-2">Kelola pesanan customer untuk produk kamu.</p>
                </div>
                <form method="GET" action="{{ route('seller.orders.index') }}" class="flex items-center gap-3">
                    <select name="status"
                        class="px-4 py-2 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition"
                        onchange="this.form.submit()">
                        <option value="">Semua status</option>
                        @foreach ($statuses as $key => $label)
                            <option value="{{ $key }}" {{ $selectedStatus === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @if ($selectedStatus)
                        <a href="{{ route('seller.orders.index') }}" class="text-secondary hover:text-primary text-sm">Reset</a>
                    @endif
                </form>
            </div>

            <div class="bg-[#212121] border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-dark-light border-b border-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Pesanan</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Qty</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Subtotal</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-dark-light transition">
                                    <td class="px-6 py-4 text-sm text-primary">
                                        <div class="font-semibold">{{ $order->product?->name ?? 'Produk dihapus' }}</div>
                                        <div class="text-xs text-secondary mt-1">
                                            {{ $order->shipping_method }} • {{ $order->payment_method }}
                                        </div>
                                        <div class="text-xs text-secondary mt-1">
                                            {{ $order->shipping_address }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-secondary">
                                        {{ $order->buyer?->name ?? 'User dihapus' }}<br>
                                        <span class="text-xs">{{ $order->buyer?->email }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        {{ $order->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        Rp{{ number_format($order->subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        {{ \Illuminate\Support\Str::headline($order->status) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        <form action="{{ route('seller.orders.update', $order->id) }}" method="POST" class="flex items-center gap-3">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status"
                                                class="px-3 py-2 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition text-sm">
                                                @foreach ($statuses as $key => $label)
                                                    <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit"
                                                class="px-3 py-2 bg-primary text-dark rounded-md text-sm font-medium hover:bg-gray-200 transition">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-6 text-center text-secondary">
                                        Belum ada pesanan masuk.
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
