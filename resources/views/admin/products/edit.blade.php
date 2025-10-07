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

                        <!-- Current Images -->
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Current Images</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($product->image)
                                    <div class="relative">
                                        <h3 class="text-sm font-medium text-secondary mb-1">Primary Image</h3>
                                        <img src="{{ $product->image }}" alt="Primary Product Image" class="w-full h-32 object-cover rounded">
                                        <a href="#" class="delete-image-btn text-red-500 text-sm mt-1 inline-block" data-field="image" data-product-id="{{ $product->id }}">Delete Image</a>
                                    </div>
                                @endif
                                
                                @for($i = 2; $i <= 5; $i++)
                                    @php
                                        $imageField = $i === 2 ? 'image2' : ($i === 3 ? 'image3' : ($i === 4 ? 'image4' : 'image5'));
                                    @endphp
                                    @if($product->$imageField)
                                        <div class="relative">
                                            <h3 class="text-sm font-medium text-secondary mb-1">Image {{ $i }}</h3>
                                            <img src="{{ $product->$imageField }}" alt="Product Image {{ $i }}" class="w-full h-32 object-cover rounded">
                                            <a href="#" class="delete-image-btn text-red-500 text-sm mt-1 inline-block" data-field="{{ $imageField }}" data-product-id="{{ $product->id }}">Delete Image</a>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        <!-- Image Upload Section -->
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Additional Images (Drag & Drop or Click - up to 5 images total)</label>
                            <div id="image-upload-area" class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center cursor-pointer bg-dark-light hover:bg-gray-800 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-500 mb-3"></i>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, JPEG, GIF, WEBP (MAX. 10MB each)
                                    </p>
                                </div>
                                <input type="file" id="image-file-input" class="hidden" accept="image/*" multiple>
                            </div>
                            <div id="image-preview-container" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                                <!-- Image previews will be added here dynamically -->
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Add more images. Drag to reorder. First image will be primary.</p>
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
            const imageFileInput = document.getElementById('image-file-input');
            const imagePreviewContainer = document.getElementById('image-preview-container');
            
            // Store uploaded files
            let uploadedFiles = [];

            if (imageUploadArea) {
                // Handle click on upload area
                imageUploadArea.addEventListener('click', function() {
                    imageFileInput.click();
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
                    handleFiles(dt.files);
                });

                // Handle file selection
                imageFileInput.addEventListener('change', function() {
                    handleFiles(this.files);
                });

                // Handle files function
                function handleFiles(files) {
                    // Convert files to array and validate
                    const filesArray = Array.from(files);
                    
                    // Validate files and filter valid ones
                    const validFiles = [];
                    for (let i = 0; i < filesArray.length; i++) {
                        const file = filesArray[i];
                        if (file.type.match('image.*') && file.size <= 10 * 1024 * 1024) { // 10MB limit
                            validFiles.push(file);
                        }
                    }
                    
                    // Check if adding these files would exceed the limit
                    if (uploadedFiles.length + validFiles.length > 5) {
                        const remainingSlots = 5 - uploadedFiles.length;
                        if (remainingSlots > 0) {
                            alert(`You can only upload up to 5 images. Adding ${validFiles.length} images would exceed the limit. Only adding ${remainingSlots} more image(s).`);
                            validFiles.splice(remainingSlots);
                        } else {
                            alert('You have reached the maximum of 5 images.');
                            return;
                        }
                    }
                    
                    // Add valid files to the uploadedFiles array
                    uploadedFiles.push(...validFiles);
                    
                    // Update previews
                    updatePreviews();
                }
                
                // Update previews function
                function updatePreviews() {
                    // Clear existing previews
                    imagePreviewContainer.innerHTML = '';
                    
                    // Create preview for each uploaded file
                    uploadedFiles.forEach((file, index) => {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const previewElement = document.createElement('div');
                            previewElement.className = 'relative group';
                            previewElement.setAttribute('data-index', index);
                            previewElement.innerHTML = `
                                <div class="relative">
                                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-24 object-cover rounded cursor-move" draggable="true">
                                    <button type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 delete-image" data-index="${index}">×</button>
                                    <span class="absolute bottom-0 left-0 bg-black bg-opacity-50 text-white text-xs px-1 rounded">${index + 1}</span>
                                </div>
                            `;
                            
                            // Add drag and drop events for reordering
                            previewElement.addEventListener('dragstart', handleDragStart);
                            previewElement.addEventListener('dragover', handleDragOver);
                            previewElement.addEventListener('dragenter', handleDragEnter);
                            previewElement.addEventListener('dragleave', handleDragLeave);
                            previewElement.addEventListener('drop', handleDrop);
                            previewElement.addEventListener('dragend', handleDragEnd);
                            
                            // Add delete event
                            previewElement.querySelector('.delete-image').addEventListener('click', function() {
                                const fileIndex = parseInt(this.getAttribute('data-index'));
                                deleteImage(fileIndex);
                            });
                            
                            imagePreviewContainer.appendChild(previewElement);
                        };
                        
                        reader.readAsDataURL(file);
                    });
                }
                
                // Variables for drag and drop
                let dragSrcElement = null;
                
                // Drag and drop functions
                function handleDragStart(e) {
                    dragSrcElement = this;
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', this.getAttribute('data-index'));
                }
                
                function handleDragOver(e) {
                    if (e.preventDefault) {
                        e.preventDefault();
                    }
                    e.dataTransfer.dropEffect = 'move';
                    return false;
                }
                
                function handleDragEnter(e) {
                    this.classList.add('border-2 border-accent');
                }
                
                function handleDragLeave(e) {
                    this.classList.remove('border-2 border-accent');
                }
                
                function handleDrop(e) {
                    if (e.stopPropagation) {
                        e.stopPropagation();
                    }
                    
                    this.classList.remove('border-2 border-accent');
                    
                    if (dragSrcElement !== this) {
                        // Get indices
                        const srcIndex = parseInt(dragSrcElement.getAttribute('data-index'));
                        const destIndex = parseInt(this.getAttribute('data-index'));
                        
                        // Reorder in the array
                        const movedFile = uploadedFiles[srcIndex];
                        uploadedFiles.splice(srcIndex, 1);
                        uploadedFiles.splice(destIndex, 0, movedFile);
                        
                        // Update previews
                        updatePreviews();
                    }
                    
                    return false;
                }
                
                function handleDragEnd(e) {
                    // Remove any highlighting
                    const items = document.querySelectorAll('#image-preview-container > div');
                    for (let i = 0; i < items.length; i++) {
                        items[i].classList.remove('border-2 border-accent');
                    }
                }
                
                // Delete image function
                function deleteImage(index) {
                    if (confirm('Are you sure you want to remove this image?')) {
                        uploadedFiles.splice(index, 1);
                        updatePreviews();
                    }
                }
            }
        });
    </script>
</x-app-layout>