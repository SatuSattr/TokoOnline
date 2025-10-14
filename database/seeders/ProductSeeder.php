<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellerIds = User::where('role', User::ROLE_SELLER)->pluck('id')->all();

        if (empty($sellerIds)) {
            return;
        }

        $products = [
            [
                'name' => 'Premium Wireless Headphones',
                'category_id' => 1,
                'price' => 2999000,
                'disc_price' => 2499000,
                'image' => '/img/wireless-headphones.jpg',
                'description' => 'High-quality wireless headphones with active noise cancellation and premium sound quality. Perfect for music lovers and professionals.',
                'rating' => 4.5,
                'reviews' => 128,
            ],
            [
                'name' => 'Running Shoes',
                'category_id' => 2,
                'price' => 599000,
                'disc_price' => null,
                'image' => '/img/running-shoes.jpg',
                'description' => 'Comfortable running shoes with advanced cushioning technology for maximum comfort during workouts.',
                'rating' => 4.2,
                'reviews' => 96,
            ],
            [
                'name' => 'Professional Camera',
                'category_id' => 1,
                'price' => 12999000,
                'disc_price' => 11999000,
                'image' => '/img/professional-camera.jpg',
                'description' => 'High-resolution digital camera with advanced features for professional photography.',
                'rating' => 4.8,
                'reviews' => 76,
            ],
            [
                'name' => 'Smart Watch',
                'category_id' => 1,
                'price' => 1999000,
                'disc_price' => 1699000,
                'image' => '/img/smart-watch.jpg',
                'description' => 'Feature-rich smartwatch with health monitoring and connectivity options.',
                'rating' => 4.3,
                'reviews' => 203,
            ],
            [
                'name' => 'Minimalist Backpack',
                'category_id' => 3,
                'price' => 499000,
                'disc_price' => null,
                'image' => '/img/minimalist-backpack.jpg',
                'description' => 'Sleek and functional backpack designed for everyday use with laptop compartment.',
                'rating' => 4.6,
                'reviews' => 142,
            ],
            [
                'name' => 'Leather Jacket',
                'category_id' => 3,
                'price' => 1299000,
                'disc_price' => 999000,
                'image' => '/img/leather-jacket.jpg',
                'description' => 'Genuine leather jacket with timeless design and premium quality material.',
                'rating' => 4.7,
                'reviews' => 89,
            ],
            [
                'name' => 'Office Chair',
                'category_id' => 3,
                'price' => 1799000,
                'disc_price' => 1499000,
                'image' => '/img/office-chair.jpg',
                'description' => 'Ergonomic office chair with lumbar support for all-day comfort.',
                'rating' => 4.4,
                'reviews' => 156,
            ],
            [
                'name' => 'Coffee Maker',
                'category_id' => 1,
                'price' => 1399000,
                'disc_price' => null,
                'image' => '/img/coffee-maker.jpg',
                'description' => 'Automatic coffee maker with programmable features for perfect coffee every morning.',
                'rating' => 4.1,
                'reviews' => 112,
            ],
        ];

        $sellerCount = count($sellerIds);
        foreach ($products as $index => $productData) {
            $sellerId = $sellerIds[$index % $sellerCount];

            Product::updateOrCreate(
                ['name' => $productData['name']],
                array_merge($productData, [
                    'user_id' => $sellerId,
                    'image2' => null,
                    'image3' => null,
                    'image4' => null,
                    'image5' => null,
                ])
            );
        }
    }
}
