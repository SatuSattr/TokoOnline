<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index()
    {
        // Get all categories
        $categories = Category::all();
        
        // Get featured products (top 8 by rating)
        $featuredProducts = Product::with(['category', 'seller'])
            ->orderBy('rating', 'desc')
            ->limit(8)
            ->get();

        return view('index', compact('categories', 'featuredProducts'));
    }
    
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        // Get all categories for the view
        $categories = Category::all();
        
        // Search products by name or description
        $featuredProducts = Product::with(['category', 'seller'])
            ->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
            })
            ->orderBy('rating', 'desc')
            ->limit(8)
            ->get();

        return view('index', compact('categories', 'featuredProducts', 'search'));
    }
    
    public function products()
    {
        // Get all categories for the sidebar/filter
        $categories = Category::all();
        
        // Get all products with category information
        $products = Product::with(['category', 'seller'])->paginate(12); // 12 products per page

        return view('products.index', compact('products', 'categories'));
    }
    
    public function product(Product $product)
    {
        $product->load(['seller', 'category']);
        // Get related products (same category, excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
