<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'disc_price' => 'nullable|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // Primary image is required
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image5' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'description' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5',
            'reviews' => 'required|integer|min:0',
        ]);

        $data = $request->except(['image', 'image2', 'image3', 'image4', 'image5']);

        // Handle primary image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $this->generateRandomFilename($file->getClientOriginalExtension());
            
            // Check if the file was actually uploaded successfully
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['image' => 'File upload failed.'])->withInput();
            }
            
            $path = $file->storeAs('img', $filename, 'public');  // Explicitly specify 'public' disk
            if ($path === false) {
                return redirect()->back()->withErrors(['image' => 'Failed to save image file.'])->withInput();
            }
            
            // The storeAs method stores the file in storage/app/public/img/ and returns "img/filename"
            // The storage link makes it accessible via /storage/img/filename
            $data['image'] = '/storage/' . $path;
        }

        // Handle additional image uploads
        for ($i = 2; $i <= 5; $i++) {
            $imageField = "image$i";
            if ($request->hasFile($imageField)) {
                $file = $request->file($imageField);
                $filename = $this->generateRandomFilename($file->getClientOriginalExtension());
                
                // Check if the file was actually uploaded successfully
                if (!$file->isValid()) {
                    return redirect()->back()->withErrors([$imageField => 'File upload failed.'])->withInput();
                }
                
                $path = $file->storeAs('img', $filename, 'public');  // Explicitly specify 'public' disk
                if ($path === false) {
                    return redirect()->back()->withErrors([$imageField => 'Failed to save image file.'])->withInput();
                }
                
                // The storeAs method stores the file in storage/app/public/img/ and returns "img/filename"
                // The storage link makes it accessible via /storage/img/filename
                $data[$imageField] = '/storage/' . $path;
            }
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'disc_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image5' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'description' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5',
            'reviews' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        $data = $request->except(['image', 'image2', 'image3', 'image4', 'image5']);

        // Handle primary image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                $oldImagePath = str_replace('/storage/', 'public/', $product->image);
                if (file_exists(storage_path('app/' . $oldImagePath))) {
                    unlink(storage_path('app/' . $oldImagePath));
                }
            }
            
            $file = $request->file('image');
            $filename = $this->generateRandomFilename($file->getClientOriginalExtension());
            
            // Check if the file was actually uploaded successfully
            if (!$file->isValid()) {
                return redirect()->back()->withErrors(['image' => 'File upload failed.'])->withInput();
            }
            
            $path = $file->storeAs('img', $filename, 'public');  // Explicitly specify 'public' disk
            if ($path === false) {
                return redirect()->back()->withErrors(['image' => 'Failed to save image file.'])->withInput();
            }
            
            // The storeAs method stores the file in storage/app/public/img/ and returns "img/filename"
            // The storage link makes it accessible via /storage/img/filename
            $data['image'] = '/storage/' . $path;
        }

        // Handle additional image uploads
        for ($i = 2; $i <= 5; $i++) {
            $imageField = "image$i";
            if ($request->hasFile($imageField)) {
                // Delete old image if exists
                if ($product->$imageField) {
                    $oldImagePath = str_replace('/storage/', 'public/', $product->$imageField);
                    if (file_exists(storage_path('app/' . $oldImagePath))) {
                        unlink(storage_path('app/' . $oldImagePath));
                    }
                }
                
                $file = $request->file($imageField);
                $filename = $this->generateRandomFilename($file->getClientOriginalExtension());
                
                // Check if the file was actually uploaded successfully
                if (!$file->isValid()) {
                    return redirect()->back()->withErrors([$imageField => 'File upload failed.'])->withInput();
                }
                
                $path = $file->storeAs('img', $filename, 'public');  // Explicitly specify 'public' disk
                if ($path === false) {
                    return redirect()->back()->withErrors([$imageField => 'Failed to save image file.'])->withInput();
                }
                
                // The storeAs method stores the file in storage/app/public/img/ and returns "img/filename"
                // The storage link makes it accessible via /storage/img/filename
                $data[$imageField] = '/storage/' . $path;
            }
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete associated images from storage
        $this->deleteProductImages($product);
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
    
    /**
     * Generate random filename
     */
    private function generateRandomFilename($extension)
    {
        return bin2hex(random_bytes(5)) . '.' . $extension;
    }
    
    /**
     * Delete product images from storage
     */
    private function deleteProductImages($product)
    {
        // Delete all 5 image columns if they exist
        for ($i = 1; $i <= 5; $i++) {
            $imageFieldName = $i === 1 ? 'image' : "image$i";
            $imagePath = $product->$imageFieldName;
            
            if ($imagePath) {
                // Remove the /storage/ prefix to get the actual file path
                $filePath = str_replace('/storage/', 'public/', $imagePath);
                
                if (file_exists(storage_path('app/' . $filePath))) {
                    unlink(storage_path('app/' . $filePath));
                }
            }
        }
    }
}
