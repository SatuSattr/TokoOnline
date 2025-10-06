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
            'images' => 'required|array|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max per image
            'description' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5',
            'reviews' => 'required|integer|min:0',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate random filename
                $filename = $this->generateRandomFilename($image->getClientOriginalExtension());
                $path = $image->storeAs('public/img', $filename);
                $imagePaths[] = '/storage/img/' . $filename;
            }
        }

        $data = $request->except(['images']);
        $data['images'] = $imagePaths;
        $data['main_image'] = !empty($imagePaths) ? $imagePaths[0] : null;

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
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max per image
            'description' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5',
            'reviews' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        $data = $request->except(['images']);

        // Handle new image uploads
        $imagePaths = $product->images; // Keep existing images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate random filename
                $filename = $this->generateRandomFilename($image->getClientOriginalExtension());
                $path = $image->storeAs('public/img', $filename);
                $imagePaths[] = '/storage/img/' . $filename;
            }

            // Limit to 5 images max
            $imagePaths = array_slice($imagePaths, 0, 5);
        }

        $data['images'] = $imagePaths;
        $data['main_image'] = !empty($imagePaths) ? $imagePaths[0] : null;

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
        $images = $product->images;
        foreach ($images as $image) {
            // Remove the /storage/ prefix to get the actual file path
            $filePath = str_replace('/storage/', 'public/', $image);
            
            if (file_exists(storage_path('app/' . $filePath))) {
                unlink(storage_path('app/' . $filePath));
            }
        }
    }
}
