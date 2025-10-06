<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Premium Wireless Headphones',
            'category_id' => 1, // electronics
            'price' => 2999000,
            'disc_price' => 2499000,
            'images' => ['/img/wireless-headphones.jpg'],
            'main_image' => '/img/wireless-headphones.jpg',
            'description' => 'High-quality wireless headphones with active noise cancellation and premium sound quality. Perfect for music lovers and professionals.',
            'rating' => 4.5,
            'reviews' => 128,
        ]);
        
        Product::create([
            'name' => 'Running Shoes',
            'category_id' => 2, // sports
            'price' => 599000,
            'disc_price' => null,
            'images' => ['/img/running-shoes.jpg'],
            'main_image' => '/img/running-shoes.jpg',
            'description' => 'Comfortable running shoes with advanced cushioning technology for maximum comfort during workouts.',
            'rating' => 4.2,
            'reviews' => 96,
        ]);
        
        Product::create([
            'name' => 'Professional Camera',
            'category_id' => 1, // electronics
            'price' => 12999000,
            'disc_price' => 11999000,
            'images' => ['/img/professional-camera.jpg'],
            'main_image' => '/img/professional-camera.jpg',
            'description' => 'High-resolution digital camera with advanced features for professional photography.',
            'rating' => 4.8,
            'reviews' => 76,
        ]);
        
        Product::create([
            'name' => 'Smart Watch',
            'category_id' => 1, // electronics
            'price' => 1999000,
            'disc_price' => 1699000,
            'images' => ['/img/smart-watch.jpg'],
            'main_image' => '/img/smart-watch.jpg',
            'description' => 'Feature-rich smartwatch with health monitoring and connectivity options.',
            'rating' => 4.3,
            'reviews' => 203,
        ]);
        
        Product::create([
            'name' => 'Minimalist Backpack',
            'category_id' => 3, // clothing/accessories
            'price' => 499000,
            'disc_price' => null,
            'images' => ['/img/minimalist-backpack.jpg'],
            'main_image' => '/img/minimalist-backpack.jpg',
            'description' => 'Sleek and functional backpack designed for everyday use with laptop compartment.',
            'rating' => 4.6,
            'reviews' => 142,
        ]);
        
        Product::create([
            'name' => 'Leather Jacket',
            'category_id' => 3, // clothing
            'price' => 1299000,
            'disc_price' => 999000,
            'images' => ['/img/leather-jacket.jpg'],
            'main_image' => '/img/leather-jacket.jpg',
            'description' => 'Genuine leather jacket with timeless design and premium quality material.',
            'rating' => 4.7,
            'reviews' => 89,
        ]);
        
        Product::create([
            'name' => 'Office Chair',
            'category_id' => 3, // furniture
            'price' => 1799000,
            'disc_price' => 1499000,
            'images' => ['/img/office-chair.jpg'],
            'main_image' => '/img/office-chair.jpg',
            'description' => 'Ergonomic office chair with lumbar support for all-day comfort.',
            'rating' => 4.4,
            'reviews' => 156,
        ]);
        
        Product::create([
            'name' => 'Coffee Maker',
            'category_id' => 1, // electronics/kitchen
            'price' => 1399000,
            'disc_price' => null,
            'images' => ['/img/coffee-maker.jpg'],
            'main_image' => '/img/coffee-maker.jpg',
            'description' => 'Automatic coffee maker with programmable features for perfect coffee every morning.',
            'rating' => 4.1,
            'reviews' => 112,
        ]);
    }
}
