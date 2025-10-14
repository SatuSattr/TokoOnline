<?php

namespace App\Http\Controllers\Seller;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'seller']);
    }

    public function index(): View
    {
        $products = Product::with('category')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all();

        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);
        $data = collect($validated)->except(['image', 'image2', 'image3', 'image4', 'image5'])->toArray();

        $data['user_id'] = auth()->id();

        $images = $this->handleImageUploads($request);
        $data = array_merge($data, $images);

        Product::create($data);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dibuat.');
    }

    public function edit(int $id): View
    {
        $product = $this->findSellerProduct($id);
        $categories = Category::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $product = $this->findSellerProduct($id);
        $validated = $this->validateProduct($request, $product->id);
        $data = collect($validated)->except(['image', 'image2', 'image3', 'image4', 'image5'])->toArray();

        $images = $this->handleImageUploads($request, $product);
        $data = array_merge($data, $images);

        $product->update($data);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = $this->findSellerProduct($id);
        $this->deleteProductImages($product);
        $product->delete();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function validateProduct(Request $request, ?int $productId = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'disc_price' => 'nullable|numeric|min:0',
            'image' => [$productId ? 'nullable' : 'required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'image5' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'description' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5',
            'reviews' => 'required|integer|min:0',
        ]);
    }

    private function handleImageUploads(Request $request, ?Product $product = null): array
    {
        $data = [];
        for ($i = 1; $i <= 5; $i++) {
            $field = $i === 1 ? 'image' : "image{$i}";
            if ($request->hasFile($field)) {
                if ($product && $product->$field) {
                    $this->removeStoredImage($product->$field);
                }

                $file = $request->file($field);
                if (!$file->isValid()) {
                    abort(422, "Upload gambar {$field} gagal.");
                }

                $path = $file->storeAs('img', $this->generateRandomFilename($file->getClientOriginalExtension()), 'public');

                if ($path === false) {
                    abort(422, "Gagal menyimpan gambar {$field}.");
                }

                $data[$field] = '/storage/' . $path;
            }
        }

        return $data;
    }

    private function removeStoredImage(string $imagePath): void
    {
        $filePath = str_replace('/storage/', 'public/', $imagePath);
        $fullPath = storage_path('app/' . $filePath);

        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }

    private function deleteProductImages(Product $product): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $field = $i === 1 ? 'image' : "image{$i}";
            if ($product->$field) {
                $this->removeStoredImage($product->$field);
            }
        }
    }

    private function generateRandomFilename(string $extension): string
    {
        return bin2hex(random_bytes(5)) . '.' . $extension;
    }

    private function findSellerProduct(int $id): Product
    {
        return Product::where('user_id', auth()->id())->findOrFail($id);
    }
}
