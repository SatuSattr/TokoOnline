<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Edit Product Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">Edit Product</h1>
                <p class="text-secondary mt-2">Update product information</p>
            </div>

            <!-- Edit Product Form -->
            <div class="bg-[#212121] border border-gray-800 rounded-xl p-6">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-secondary mb-2">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition" required>
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-secondary mb-2">Category</label>
                            <select name="category_id" id="category_id" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary focus:outline-none focus:border-accent transition" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-secondary mb-2">Price</label>
                            <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $product->price) }}" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition" required>
                        </div>

                        <div>
                            <label for="disc_price" class="block text-sm font-medium text-secondary mb-2">Discount Price (Optional)</label>
                            <input type="number" name="disc_price" id="disc_price" step="0.01" value="{{ old('disc_price', $product->disc_price) }}" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition">
                        </div>

                        <!-- Existing Images -->
                        @if($product->images && count($product->images) > 0)
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">Existing Images</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                                    @foreach($product->images as $image)
                                        <div class="relative">
                                            <img src="{{ $image }}" alt="Product Image" class="w-full h-24 object-cover rounded">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Image Upload Section -->
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Add More Images (Max 5 images, 10MB each)</label>
                            <div id="image-upload-area" class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center cursor-pointer bg-dark-light hover:bg-gray-800 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-500 mb-3"></i>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, JPEG, GIF, WEBP (MAX. 10MB)
                                    </p>
                                </div>
                                <input type="file" name="images[]" id="images" class="hidden" accept="image/*" multiple>
                            </div>
                            <div id="image-preview-container" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 hidden">
                                <!-- Preview images will be added here dynamically -->
                            </div>
                            <p class="text-xs text-gray-500 mt-2">You can upload up to 5 images</p>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-secondary mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div>
                            <label for="rating" class="block text-sm font-medium text-secondary mb-2">Rating (0-5)</label>
                            <input type="number" name="rating" id="rating" min="0" max="5" step="0.1" value="{{ old('rating', $product->rating) }}" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition" required>
                        </div>

                        <div>
                            <label for="reviews" class="block text-sm font-medium text-secondary mb-2">Reviews Count</label>
                            <input type="number" name="reviews" id="reviews" value="{{ old('reviews', $product->reviews) }}" class="w-full px-4 py-3 bg-dark-light border border-gray-800 rounded-lg text-primary placeholder-secondary focus:outline-none focus:border-accent transition" required>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <button type="submit" class="bg-primary text-dark px-6 py-3 rounded-lg hover:bg-gray-200 transition font-medium">
                            Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="bg-dark-light text-primary px-6 py-3 rounded-lg border border-gray-800 hover:bg-gray-800 transition font-medium">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Upload Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageUploadArea = document.getElementById('image-upload-area');
            const imageInput = document.getElementById('images');
            const previewContainer = document.getElementById('image-preview-container');

            // Handle click on upload area
            imageUploadArea.addEventListener('click', function() {
                imageInput.click();
            });

            // Handle drag and drop events
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                imageUploadArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                imageUploadArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                imageUploadArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                imageUploadArea.classList.add('border-accent', 'bg-gray-800');
            }

            function unhighlight(e) {
                imageUploadArea.classList.remove('border-accent', 'bg-gray-800');
            }

            // Handle dropped files
            imageUploadArea.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles(files);
            });

            // Handle file selection
            imageInput.addEventListener('change', function() {
                handleFiles(this.files);
            });

            // Handle files function
            function handleFiles(files) {
                // Clear existing previews
                previewContainer.innerHTML = '';
                
                // Validate file count and type
                let validFiles = [];
                for (let i = 0; i < files.length && i < 5; i++) {
                    const file = files[i];
                    if (file.type.match('image.*') && file.size <= 10 * 1024 * 1024) { // 10MB limit
                        validFiles.push(file);
                    }
                }
                
                // Create new DataTransfer to hold valid files
                const dataTransfer = new DataTransfer();
                validFiles.forEach(file => dataTransfer.items.add(file));
                imageInput.files = dataTransfer.files;
                
                // Create previews
                validFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewElement = document.createElement('div');
                        previewElement.className = 'relative';
                        previewElement.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" class="w-full h-24 object-cover rounded">
                            <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs remove-image" data-index="${index}">×</button>
                        `;
                        
                        previewContainer.appendChild(previewElement);
                        
                        // Add event listener to remove button
                        previewElement.querySelector('.remove-image').addEventListener('click', function(e) {
                            e.stopPropagation();
                            previewElement.remove();
                            
                            // Update file input
                            const dt = new DataTransfer();
                            Array.from(imageInput.files).forEach((f, i) => {
                                if (i !== index) {
                                    dt.items.add(f);
                                }
                            });
                            imageInput.files = dt.files;
                            
                            // Hide preview container if no images
                            if (dt.files.length === 0) {
                                previewContainer.classList.add('hidden');
                            }
                        });
                    };
                    reader.readAsDataURL(file);
                });
                
                // Show preview container if we have valid files
                if (validFiles.length > 0) {
                    previewContainer.classList.remove('hidden');
                } else {
                    previewContainer.classList.add('hidden');
                }
            }
        });
    </script>
</x-app-layout>