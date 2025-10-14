<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Produk Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-primary">Produk Saya</h1>
                    <p class="text-secondary mt-2">Kelola daftar produk yang kamu jual.</p>
                </div>
                <a href="{{ route('seller.products.create') }}"
                    class="inline-flex items-center px-5 py-3 bg-primary text-dark rounded-lg font-medium hover:bg-gray-200 transition">
                    <i class="fas fa-plus mr-2"></i> Tambah Produk
                </a>
            </div>

            <div class="bg-[#212121] border border-gray-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-dark-light border-b border-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Produk</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Harga</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Rating</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-secondary uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse ($products as $product)
                                <tr class="hover:bg-dark-light transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
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
                                            <div>
                                                <div class="text-primary font-semibold">{{ $product->name }}</div>
                                                <div class="text-secondary text-xs">Dibuat {{ $product->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        {{ $product->category?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        {{ $product->formatted_price }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        {{ number_format($product->rating, 1) }} ({{ $product->reviews }} ulasan)
                                    </td>
                                    <td class="px-6 py-4 text-sm text-primary">
                                        <a href="{{ route('seller.products.edit', $product->id) }}"
                                            class="text-accent hover:text-accent-hover mr-3">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-6 text-center text-secondary">
                                        Belum ada produk. Mulai dengan menambahkan produk baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-800">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
