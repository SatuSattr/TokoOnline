<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Edit Produk</h1>
                <p class="text-secondary mt-2">Perbarui detail produk kamu.</p>
            </div>

            <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Kategori</label>
                            <select name="category_id"
                                class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition"
                                required>
                                <option value="">Pilih kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Harga</label>
                            <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}"
                                class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Harga Diskon</label>
                            <input type="number" step="0.01" min="0" name="disc_price" value="{{ old('disc_price', $product->disc_price) }}"
                                class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-secondary mb-2">Deskripsi</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Rating</label>
                            <input type="number" step="0.1" min="0" max="5" name="rating" value="{{ old('rating', $product->rating) }}"
                                class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Jumlah Review</label>
                            <input type="number" min="0" name="reviews" value="{{ old('reviews', $product->reviews) }}"
                                class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition"
                                required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-secondary mb-4">Gambar Produk</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @for ($i = 1; $i <= 5; $i++)
                                @php
                                    $field = $i === 1 ? 'image' : 'image' . $i;
                                    $label = $i === 1 ? 'Gambar Utama' : 'Gambar Tambahan ' . $i;
                                @endphp
                                <div>
                                    <span class="text-xs text-secondary uppercase">{{ $label }}</span>
                                    <input type="file" name="{{ $field }}"
                                        class="mt-2 block w-full text-sm text-secondary file:mr-4 file:rounded-md file:border-0 file:bg-primary file:px-4 file:py-2 file:text-dark hover:file:bg-gray-200">
                                    @if ($product->$field)
                                        <img src="{{ $product->$field }}" alt="{{ $product->name }}"
                                            class="mt-2 w-32 h-32 object-cover rounded-md border border-gray-800"
                                            onerror="this.src='{{ asset('img/hero.jpg') }}'; this.onerror=null;">
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('seller.products.index') }}"
                            class="px-5 py-3 bg-dark-light border border-gray-800 text-primary rounded-lg hover:bg-gray-800 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-3 bg-primary text-dark rounded-lg font-medium hover:bg-gray-200 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
